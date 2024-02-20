<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coments = Comment::all();

        if ($coments) {
            return response()->json([
                'success' =>true,
                'data' =>$coments,
            ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'error al llistar els comentaris',
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request , string $id)
    {
        $post = Post::find($id);
        if ($post){
            $comment = comment::create([
                'post_id' => $post->id,
                'user_id' => $request->user()->id,
                'body' => $request->input('body')
            ]);
            if ($comment){
                return response()->json([
                    'success' => true,
                    'data' => $comment,
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear el comentario',
                ], 403);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Error post no encontrado',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $post_id, string $comment_id)
    {
        $comment = Comment::find($comment_id);

        if ($comment) {
            $comment->delete();

            return response()->json([
                'success' => true,
                'data' => $comment,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Comentario no encontrado',
            ], 404);
        }
    }
}
