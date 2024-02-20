<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\place;
use App\Models\User;
use App\Models\Review;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        $reviews = Review::where('place_id', $id);
        if ($reviews) {
            return response()->json([
                'success' =>true,
                'data' =>$reviews,
            ],200);
        }else{
            return response()->json([
                'success' =>false,
                'message' =>'error al llistar els arxius',
            ],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $place = Place::find($id);
        if ($place){
            $review = Review::create([
                'place_id' => $place->id,
                'user_id' => $request->user()->id,
                'body' => $request->input('body')
            ]);
            if ($review){
                return response()->json([
                    'success' => true,
                    'data' => $review,
                ], 200);
            }
            else{
                return response()->json([
                    'success' => false,
                    'message' => 'Error al crear la review',
                ], 403);
            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => 'Error place no encontrado',
            ], 404);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,string $idPlace, string $idReview)
    {
        $review = Review::find($idReview);

        if ($review) {
            $review->delete();

            return response()->json([
                'success' => true,
                'data' => $review,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'review no encontrado',
            ], 404);
        }
    }
}
