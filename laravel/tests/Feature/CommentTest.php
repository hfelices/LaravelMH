<?php

namespace Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

class CommentTest extends TestCase
{
    public static User $testUser;   
    public static array $testUserData = [];
    public static array $validData = [];
    public static array $invalidData = [];
   
    public static function setUpBeforeClass() : void
    {
     
         parent::setUpBeforeClass();
         // Creem usuari/a de prova
         $name = "test_" . time();
         self::$testUserData = [
             "name"      => "{$name}",
             "email"     => "{$name}@mailinator.com",
             "password"  => "12345678"
         ];
         // TODO Omplir amb dades vàlides
         self::$validData = [];
         // TODO Omplir amb dades incorrectes
         self::$invalidData = [];
 
    }
 
    public function test_post_first()
    {
         // Desem l'usuari al primer test
         self::$testUser = new User(self::$testUserData);
         self::$testUser->save();
         // Comprovem que s'ha creat
         $this->assertDatabaseHas('users', [
             'email' => self::$testUserData['email'],
         ]);
  
    }

    public function test_post_create() : object
    {
        Sanctum::actingAs(self::$testUser);
        // Create fake file
        $name  = "avatar.png";
        $size = 500; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        $body = "body";
        $latitude = 1;
        $longitude = 1;
         // Upload fake file using API web service
       $response = $this->postJson("/api/posts", [
            "upload" => $upload,
            "name" => $name,
            "body" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude
        ]);
        // Check OK response
       $this->_test_ok($response, 201);
       // Check validation errors
       $response->assertValid(["upload", "name", "body", "latitude", "longitude"]);
       // Check JSON exact values
       // Check JSON dynamic values
       $response->assertJsonPath("data.id",
           fn ($id) => !empty($id)
       );
       // Read, update and delete dependency!!!
       $json = $response->getData();
       return $json->data;
    }
   /**
    * @depends test_post_create
    */
    public function test_comment_create(object $post) : object
   {
       // Create fake file
       Sanctum::actingAs(self::$testUser);
       $body  = "definitivamente un comment";
       $response = $this->postJson("/api/posts/{$post->id}/comment", [
           "body" => $body
       ]);
       // Check OK response
       $this->_test_ok($response, 200);
       // Check validation errors
       $response->assertValid(["user_id", "post_id", "body"]);
       // Check JSON exact values
       // Check JSON dynamic values
       $response->assertJsonPath("data.id",
           fn ($id) => !empty($id)
       );
       // Read, update and delete dependency!!!
       $json = $response->getData();
       \Log::debug("{$json->data->id} create");
       return $json->data;
   }

   /**
    * @depends test_post_create
    */
   public function test_comment_list(object $post)
   {
       // Read one file

       Sanctum::actingAs(new User(self::$testUserData));
       $response = $this->getJson("/api/posts/{$post->id}/comment");
       // Check OK response
       $this->_test_ok($response);
       // Check JSON exact values
       $response->assertValid(["author_id", "post_id", "body"]);
   }
  
    /**
    * @depends test_post_create
    * @depends test_comment_create
    */
    public function test_comment_delete(object $post, object $comment)
    {
        // Delete one file using API web service
 
        Sanctum::actingAs(new User(self::$testUserData));
        
        \Log::debug("{$comment->id} delete");
        $response = $this->deleteJson("/api/posts/{$post->id}/comment/{$comment->id}");
        // Check OK response
        $this->_test_ok($response);
    }

   /**
    * @depends test_post_create
    */
    public function test_post_delete(object $post)
    {
        // Delete one file using API web service
 
        Sanctum::actingAs(new User(self::$testUserData));
        $response = $this->deleteJson("/api/posts/{$post->id}");
        // Check OK response
        $this->_test_ok($response);
    }


    public function test_post_last()
    {
        // Eliminem l'usuari al darrer test
        $user = self::$testUser;
        $user->delete();
        // Comprovem que s'ha eliminat
        $this->assertDatabaseMissing('users', [
            'email' => self::$testUser['email'],
        ]);
    }

   protected function _test_ok($response, $status = 200)
   {
       // Check JSON response
       $response->assertStatus($status);
       // Check JSON properties
       $response->assertJson([
           "success" => true,
       ]);
       // Check JSON dynamic values
       $response->assertJsonPath("data",
           fn ($data) => is_array($data)
       );
   }


   protected function _test_error($response)
   {
       // Check response
       $response->assertStatus(422);
       // Check validation errors
       $response->assertInvalid(["upload"]);
       // Check JSON properties
       $response->assertJson([
           "message" => true, // any value
           "errors"  => true, // any value
       ]);       
       // Check JSON dynamic values
       $response->assertJsonPath("message",
           fn ($message) => !empty($message) && is_string($message)
       );
       $response->assertJsonPath("errors",
           fn ($errors) => is_array($errors)
       );
   }
  
   protected function _test_notfound($response)
   {
       // Check JSON response
       $response->assertStatus(404);
       // Check JSON properties
       $response->assertJson([
           "success" => false,
           "message" => true // any value
       ]);
       // Check JSON dynamic values
       $response->assertJsonPath("message",
           fn ($message) => !empty($message) && is_string($message)
       );       
   }
}
