<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Favorite;
use App\Models\Place;
use App\Models\Review;
use App\Models\File;

class ReviewController extends Controller
{
    public function store(Request $request, Place $place)
    {
        
        $validatedData = $request->validate([
            'body' => 'required|string|max:255'
         ]);
        $hola = $request->input('body');
        \Log::debug("{$hola}");
        $place = Place::find($place->id);
        if ($place){
            $review = Review::create([
                'place_id' => $place->id,
                'user_id' => $request->user()->id,
                'body' => $request->input('body')
            ]);
            if ($review){
                return redirect()->route('places.show', $place)
                    ->with('success', __('Review created successfully'));
            }
            else{
                return redirect()->route('places.show', $place)
                    ->with('ERROR', __('Review not created'));
            }
        }
        else {
            return redirect()->route('places.list')
                ->with('ERROR', __('Place not found'));
        }

    }
    public function destroy(string $id)
    {
        $review = Review::findorfail($id);
        $place = $review->place_id;
        $review->delete();

        return redirect()->route('places.show', $place)
        ->with('success', __('Review successfully removed'));

    }
}
