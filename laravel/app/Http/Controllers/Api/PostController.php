<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\File;
use App\Models\User;
use App\Models\Like;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index()
    {
        $posts = Post::all();

        if ($posts) {
            return response()->json([
                'success' =>true,
                'data' =>$posts,
            ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'error al llistar els posts',
            ],500);
        }
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
                    return response()->json([
                        'success' => true,
                        'data'    => $post
                    ], 201);
            }else{
                return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
            }
            
        } else {
            \Log::debug("Disk storage FAILS");
            // Patró PRG amb missatge d'error
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading file'
            ], 500);
        }
    }
 

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        $post = Post::find($id);
        if ($post) {
            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Error al mostrar un archivo',
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if($post){
            $oldfilePath = $post->file->filepath;
        
            // Validar fitxer
           $validatedData = $request->validate([
                'body' => 'nullable',
                'upload' => 'nullable|mimes:gif,jpeg,jpg,png|max:1024'
            ]);
    
            if ($request->hasFile('upload')) {
             // Obtenir dades del fitxer
                $upload = $request->file('upload');
                $fileName = $upload->getClientOriginalName();
                $fileSize = $upload->getSize();
                
                    
                // Pujar fitxer al disc dur
                $uploadName = time() . '_' . $fileName;
                $filePath = $upload->storeAs(
                    'uploads',      // Path
                    $uploadName ,   // Filename
                    'public'        // Disk
                );
                
                if (\Storage::disk('public')->exists($filePath)) {
                    
                    $fullPath = \Storage::disk('public')->path($filePath);
                    
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
                        ]);
    
                        \Storage::disk('public')->delete($oldfilePath);
                        // Patró PRG amb missatge d'èxit
                        return response()->json([
                            'success' => true,
                            'data'    => $post
                        ], 200);
                    }else{
                        return response()->json([
                            'success'  => false,
                            'message' => 'Error uploading post'
                        ], 500);
                    }
    
                }else{
                
                    return response()->json([
                        'success'  => false,
                        'message' => 'Error uploading post'
                    ], 500);
                    
                }
            
            
            }else{
                $post->update([
                    'body'=>$request->input('body'),
                    'file_id'=>$post->file->id,
                    'latitude'=>$request->input('latitude'),
                    'longitude'=>$request->input('longitude'),
                    // 'visibility_id',     
                ]);
                
                
            
            
                
                return response()->json([
                    'success' => true,
                    'data'    => $post
                ], 201); 
            }
        }else{
            return response()->json([
                'success'  => false,
                'message' => 'Error uploading post'
            ], 404);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        $post = Post::find($id);
        if ($post) {
            $file = File::find($post->file_id);
            $post->delete();

            $file->diskDelete();
            $file->delete();

            return response()->json([
                'success' => true,
                'data' => $post,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Archivo no encontrado',
            ], 404);
        }
    }

    //metodo update API
    public function update_workaround(Request $request, $id)
    {
        return $this->update($request, $id);
    }

    public function like(Request $request, String $id)
    {
        // $this->authorize('create', $post);
        $post = Post::where('id', $id)->first();
        if ($post) {
            $user = User::where('id', $request->user()->id)->first(); 
            if ($user) {
                $like = Like::where('user_id', $request->user()->id)->where('post_id',$id )->first();
                if (!$like) {
                    $new_like = Like::create([
                        'user_id' => $request->user()->id,
                        'post_id' => $id,
                    ]);                
                    if ($new_like) {
                        return response()->json([
                            'success' => true,
                            'data' => $like,
                        ], 200);
                    }else{
                        return response()->json([
                            'success' => false,
                            'message' => 'Error al crear el like',
                        ], 404);
                    }
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Error al crear el like, el like ya existe',
                    ], 404);
                }
                
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el like, usuario no encontrado',
                ], 404);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Error al crear el like, post no encontrado',
            ], 404);
        }
        
        
        
    }

    public function unlike(Request $request, String $id)
    {
        // $this->authorize('create', $post);
        // $user_id = Auth::user()->id;

        $post = Post::where('id', $id)->first();
        if ($post) {

            $user = User::where('id', $request->user()->id)->first();
            if ($user) {
                $like = Like::where('post_id', $post->id)
                ->where('user_id', $request->user()->id)
                ->first();
    
                if ($like) {
                    $like->delete();
                    return response()->json([
                        'success' => true,
                        'data' => $like,
                    ], 200);
                }else{
                    return response()->json([
                        'success' => false,
                        'message' => 'Archivo no encontrado',
                    ], 404);
                }
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Usuario no encontrado',
                ], 404);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Post no encontrado',
            ], 404);
        }
        
        
    }
}
