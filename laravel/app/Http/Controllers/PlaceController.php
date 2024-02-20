<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Place;
use App\Models\Review;
use App\Models\File;
use Illuminate\Http\Request;


class PlaceController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Place::class, 'place');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
   
            // Realizar la búsqueda en la base de datos
            $places = Place::withCount('favorited')
            ->where('description', 'like', "%$searchTerm%")
            ->paginate(10);
            foreach ($places->items() as $place) {
                $favorited = Favorite::where('place_id', $place->id)
                            ->where('user_id', \Auth::user()->id)
                            ->get();
                $favoritedByUser = ($favorited->count() > 0) ? true : false;
                $place->favoritedByUser = $favoritedByUser;
            }
            return view('home', compact('places'));
        } else {
            $places =  Place::withCount('favorited')
                            ->paginate(10);
            
            foreach ($places->items() as $place) {
                $favorited = Favorite::where('place_id', $place->id)
                            ->where('user_id', \Auth::user()->id)
                            ->get();
                $favoritedByUser = ($favorited->count() > 0) ? true : false;
                $place->favoritedByUser = $favoritedByUser;
            }
            return view('home', compact('places'));
        }
    }
 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("places.create");
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
            $file_id = File::where('filepath',$filePath)->where('filesize',$fileSize)->first();
            if ($file_id){
                $place = Place::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'file_id' => $file_id->id,
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'author_id' => $request->user()->id,
                ]);
                \Log::debug("DB storage OK");
                // Patró PRG amb missatge d'èxit
                return redirect()->route('places.show', $place)
                    ->with('success', __('Place successfully created'));
            } else {
                return redirect()->route("places.create")
                    ->with('error', __('ERROR uploading file'));
            }
           
       } else {
           \Log::debug("Disk storage FAILS");
           // Patró PRG amb missatge d'error
           return redirect()->route("places.create")
               ->with('error', __('ERROR uploading file'));
       }
   }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Place $place)
    {
        $favorited = Favorite::where('place_id',$place->id)->where('user_id', $request->user()->id)->get();
        $reviews = Review::where('place_id',$place->id)->get();
        $userFav = ($favorited->count() > 0) ? true : false;     
        $favorites = Favorite::where('place_id',$place->id)->get();
        if ($favorites){
            $favorites = $favorites->count();
        } else{
            $favorites = 0;
        }
        
        return view("places.show")->with(['place' => $place, 'favorites' => $favorites, 'userFav' => $userFav, 'reviews' => $reviews]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Place $place)
    {

        return view("places.edit")->with('place', $place);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Place $place)
    {
    $oldfilePath = $place->file->filepath;
        
       $validatedData = $request->validate([
        'upload' => 'nullable|mimes:gif,jpeg,jpg,png|max:1024'
     ]);
        if ($request->hasFile('upload')){
         $upload = $request->file('upload');
         $fileName = $upload->getClientOriginalName();
         $fileSize = $upload->getSize();
         \Log::debug("Storing file '{$fileName}' ($fileSize)...");
          

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
            $place->file->update([
              'filepath' => $filePath,
              'filesize' => $fileSize,
            ]);
            \Log::debug("DB storage OK");
            \Storage::disk('public')->delete($oldfilePath);
            $file_id = File::where('filepath',$filePath)->where('filesize',$fileSize)->first();
            if ($file_id){
            $place->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'file_id' => $file_id->id,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'author_id' => $request->user()->id,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully changed'));
        } else {
            return redirect()->route("places.edit", $place)
                ->with('error', __('ERROR uploading file'));
        }
        }
    }else {

        $file_id = File::where('filepath',$place->file->filepath)->where('filesize',$place->file->filesize)->first();
        if ($file_id){
            $place->update([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'file_id' => $file_id->id,
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'author_id' => $request->user()->id,
            ]);
            \Log::debug("DB storage OK");
            // Patró PRG amb missatge d'èxit
            return redirect()->route('places.show', $place)
                ->with('success', __('Place successfully changed'));
        } else {
            return redirect()->route("places.edit", $place)
                ->with('error', __('ERROR uploading file'));
        }
        \Log::debug("Disk storage FAILS");
        // Patró PRG amb missatge d'error
        return redirect()->route("places.edit", $place)
            ->with('error', __('ERROR uploading file'));
    }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Place $place)
    {
        $filePath = $place->file->filepath;
        \Storage::disk('public')->delete($filePath);
        $place->delete();
        return redirect()->route('places.index')
            ->with('success', 'Place successfully eliminated');
    }
    public function favorite(Request $request, Place $place)
    {
        $favorite = Favorite::where('place_id',$place->id)->where('user_id', $request->user()->id)->first();
        if ($favorite){
            $favorite->delete();
        } else{
            $favorite = Favorite::create([
                'user_id' => $request->user()->id,
                'place_id' => $place->id,
            ]);
        }
        return back();
    }
}
