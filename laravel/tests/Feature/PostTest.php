<?php

namespace Tests\Feature\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use Illuminate\Testing\Fluent\AssertableJson;

class PostTest extends TestCase
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


    public function test_post_list()
    {

        Sanctum::actingAs(self::$testUser);
        // List all posts using API web service
        $response = $this->getJson("/api/posts");
        // Check OK response
        $this->_test_ok($response);
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
 
 
    public function test_post_create_error()
   {
       // Create fake file with invalid max size

       Sanctum::actingAs(new User(self::$testUserData));
       $name  = "avatar.png";
       $size = 5000; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       $name = "prueba";
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
       // Check ERROR response
       $this->_test_error($response);
   }
 
 
    /**
    * @depends test_post_create
    */
    public function test_post_read(object $post)
   {
       // Read one file

       Sanctum::actingAs(new User(self::$testUserData));
       $response = $this->getJson("/api/posts/{$post->id}");
       // Check OK response
       $this->_test_ok($response);
       // Check JSON exact values
       $response->assertValid(["upload", "name", "body", "latitude", "longitude"]);
   }
   
   public function test_posts_read_notfound()
   {

    Sanctum::actingAs(new User(self::$testUserData));
       $id = "not_exists";
       $response = $this->getJson("/api/posts/{$id}");
       $this->_test_notfound($response);
   }
 
 
    /**
     * @depends test_post_create
     */
    public function test_post_update(object $post)
    {
        // Create fake file
 
        Sanctum::actingAs(new User(self::$testUserData));
        $name  = "photo.jpg";
        $size = 1000; /*KB*/
        $upload = UploadedFile::fake()->image($name)->size($size);
        // Upload fake file using API web service
        $name = "prueba_update";
        $body = "body";
        $latitude = 1;
        $longitude = 1;
        $response = $this->putJson("/api/posts/{$post->id}", [
            "upload" => $upload,
            "name" => $name,
            "body" => $body,
            "latitude" => $latitude,
            "longitude" => $longitude
        ]);
        // Check OK response
        $this->_test_ok($response);
        // Check validation errors
        $response->assertValid(["upload", "name", "body", "latitude", "longitude"]);
    }
 
 
    /**
     * @depends test_post_create
     */
    public function test_post_update_error(object $post)
   {
       // Create fake file with invalid max size

       Sanctum::actingAs(new User(self::$testUserData));
       $name  = "photo.jpg";
       $size = 3000; /*KB*/
       $upload = UploadedFile::fake()->image($name)->size($size);
       // Upload fake file using API web service
       $name = "prueba_update";
       $body = "body";
       $latitude = 1;
       $longitude = 1;
       $response = $this->putJson("/api/posts/{$post->id}", [
           "upload" => $upload,
           "name" => $name,
           "body" => $body,
           "latitude" => $latitude,
           "longitude" => $longitude
       ]);
       // Check ERROR response
       $this->_test_error($response);
   }
 
 
   public function test_post_update_notfound()
   {
       Sanctum::actingAs(new User(self::$testUserData));
       $id = "not_exists";
       $response = $this->putJson("/api/posts/{$id}", []);
       $this->_test_notfound($response);
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
 
 
   public function test_post_delete_notfound()
   {

    Sanctum::actingAs(new User(self::$testUserData));
       $id = "not_exists";
       $response = $this->deleteJson("/api/posts/{$id}");
       $this->_test_notfound($response);
       
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
