<?php

namespace App\Http\Controllers;
use App\Models\File;
use App\Models\Post;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;

class PostController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
    
            // Realizar la búsqueda en la base de datos
            $posts = Post::withCount('liked')
                            ->where('body', 'like', "%$searchTerm%")
                            ->paginate(10);

            foreach ($posts->items() as $post) {
                $liked = Like::where('post_id', $post->id)
                            ->where('user_id', Auth::user()->id)
                            ->get();
                $likedByUser = ($liked->count() > 0) ? true : false;
                $post->likedByUser = $likedByUser;
            }

            

            return view('home', compact('posts'));
        } else {

            $posts =  Post::withCount('liked')
                            ->paginate(10);
            
            foreach ($posts->items() as $post) {
                $liked = Like::where('post_id', $post->id)
                            ->where('user_id', Auth::user()->id)
                            ->get();
                $likedByUser = ($liked->count() > 0) ? true : false;
                $post->likedByUser = $likedByUser;
            }
             
            return view("home", compact('posts'));
        }
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("posts.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
       // Validar fitxer
       $validatedData = $request->validate([
           'upload' => 'required|mimes:gif,jpeg,jpg,png|max:1024'
       ]);
      
       // Obtenir dades del fitxer
       $upload = $request->file('upload');
       $fileName = $upload->getClientOriginalName();
       $fileSize = $upload->getSize();
       \Log::debug("Storing file '{$fileName}' ($fileSize)...");


       // Pujar fitxer al disc dur
       $uploadName = time() . '_' . $fileName;
       $filePath = $upload->storeAs(
           'uploads',      // Path
           $uploadName ,   // Filename
           'public'        // Disk
       );
      
       if (\Storage::disk('public')->exists($filePath)) {
           \Log::debug("Disk storage OK");
           $fullPath = \Storage::disk('public')->path($filePath);
           \Log::debug("File saved at {$fullPath}");
           // Desar dades a BD
           $file = File::create([
               'filepath' => $filePath,
               'filesize' => $fileSize,
           ]);

           $newFile = File::where('filepath', $filePath)
                            ->where('filesize', $fileSize)
                            ->first();
            if ($newFile) {
                $post = Post::create([
                    'body'=>$request->input('body'),
                    'file_id'=>$newFile->id,
                    'latitude'=>$request->input('latitude'),
                    'longitude'=>$request->input('longitude'),
                    // 'visibility_id',
                    'author_id'=>$request->user()->id,     
                   ]);
                   \Log::debug("DB storage OK");
                   // Patró PRG amb missatge d'èxit
                   return redirect()->route('posts.show', $post)
                       ->with('success', __('File successfully saved'));
            }else{
                return redirect()->route("posts.create")
               ->with('error', __('ERROR uploading file'));
            }
           
       } else {
           \Log::debug("Disk storage FAILS");
           // Patró PRG amb missatge d'error
           return redirect()->route("posts.create")
               ->with('error', __('ERROR uploading file'));
       }
   }


    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $user_id = Auth::user()->id;
        $likes = Like::where('post_id', $post->id)->get();
        $comments = Comment::where('post_id', $post->id)->get();
        $liked = Like::where('post_id', $post->id)
                    ->where('user_id', $user_id)
                    ->get();

        $likesNum = $likes->count();
        $likedByUser = ($liked->count() > 0) ? true : false;
    return view("posts.show")->with(['post' => $post,'likes' => $likesNum , 'likedByUser' => $likedByUser, 'comments' => $comments ]);
    }   

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {

        return view("posts.edit")->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $oldfilePath = $post->file->filepath;
        
        // Validar fitxer
       $validatedData = $request->validate([
            'body' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'upload' => 'nullable|mimes:gif,jpeg,jpg,png|max:1024'
        ]);

        if ($request->hasFile('upload')) {
         // Obtenir dades del fitxer
            $upload = $request->file('upload');
            $fileName = $upload->getClientOriginalName();
            $fileSize = $upload->getSize();
            \Log::debug("Storing file '{$fileName}' ($fileSize)...");
                


            // Pujar fitxer al disc dur
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',      // Path
                $uploadName ,   // Filename
                'public'        // Disk
            );
            
            if (\Storage::disk('public')->exists($filePath)) {
                \Log::debug("Disk storage OK");
                $fullPath = \Storage::disk('public')->path($filePath);
                \Log::debug("File saved at {$fullPath}");
                // Desar dades a BD
                $post->file->update([
                    'filepath' => $filePath,
                    'filesize' => $fileSize,
                ]);
                $newFile = File::where('filepath', $filePath)
                                    ->where('filesize', $fileSize)
                                    ->first();

                if ($newFile) {
                    $post->update([
                        'body'=>$request->input('body'),
                        'file_id'=>$newFile->id,
                        'latitude'=>$request->input('latitude'),
                        'longitude'=>$request->input('longitude'),
                        // 'visibility_id',
                        'author_id'=>$request->user()->id,     
                    ]);
                    \Log::debug("DB storage OK");

                    \Storage::disk('public')->delete($oldfilePath);
                    // Patró PRG amb missatge d'èxit
                    return redirect()->route('posts.show', $post)
                        ->with('success', __('File successfully saved'));
                }else{
                    return redirect()->route("posts.edit",$post)
                ->with('error', __('ERROR uploading file'));
                }

            }else{
            
                \Log::debug("Disk storage FAILS");
                // Patró PRG amb missatge d'error
                
            }
        
        
        }else{
            $post->update([
                'body'=>$request->input('body'),
                'file_id'=>$post->file->id,
                'latitude'=>$request->input('latitude'),
                'longitude'=>$request->input('longitude'),
                // 'visibility_id',
                'author_id'=>$request->user()->id,     
            ]);
            
            
        
        
            
            return redirect()->route('posts.show', $post)
                ->with('success', __('File successfully saved')); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $filePath = $post->file->filepath;
        \Storage::disk('public')->delete($filePath);
        $post->delete();
        $post->file->delete();
        return redirect()->route('posts.index')
            ->with('success', __('File successfully eliminated'));
    }

    public function like(Request $request, Post $post)
    {
        $this->authorize('create', $post);
        $like = Like::create([
            'user_id' => $request->user()->id,
            'post_id' => $post->id,
        ]);
        

        return back();
        
    }

    public function unlike(Post $post)
    {
        $this->authorize('create', $post);
        $user_id = Auth::user()->id;
        $like = Like::where('post_id', $post->id)
                    ->where('user_id', $user_id)
                    ->first();
        
        $like->delete();

        return back(); 
    }
}
