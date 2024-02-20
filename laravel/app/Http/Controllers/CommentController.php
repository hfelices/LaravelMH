<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
class CommentController extends Controller
{
    


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $post)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $comment = Comment::create([
            'body'=>$request->input('body'),
            'user_id'=>$request->user()->id,
            'post_id' => $post, 
        ]);
        
        return back();
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::findorfail($id);
        $post = $comment->post_id;
        $comment->delete();

        return back();
    }
}
