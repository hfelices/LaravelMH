<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\place;
use App\Models\File;
use Illuminate\Support\Facades\Log;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $places = Place::all();

        if ($places) {
            return response()->json([
                'success' =>true,
                'data' =>$places,
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'upload' => 'required|mimes:gif,jpeg,jpg,png|max:2048',
            'longitude' => 'required',
            'latitude' => 'required',
            'author_id' => 'required',
        ]);
        $upload = $request->file('upload');
        $fileName = $upload->getClientOriginalName();
        $fileSize = $upload->getSize();
        $file = new File();
        $ok = $file->diskSave($upload);
        $uploadName = time() . '_' . $fileName;
        $filePath = $upload->storeAs(
           'uploads',      // Path
           $uploadName ,   // Filename
           'public'        // Disk
        );
        
        if ($ok) {
            $file_id = File::where('filepath',$filePath)->where('filesize',$fileSize)->first();
            if ($file_id){
                $place = Place::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'file_id' => $file_id->id,
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'author_id' => $request->input('author_id'),
                ]);
                return response()->json([
                    'success' => true,
                    'data'    => $place
                ], 201);
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error creating place'
                ], 500);
            }

        } else {
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
        $place = Place::find($id);
        if ($place) {
            return response()->json([
                'success' => true,
                'data' => $place,
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
        $place = Place::find($id);
        if ($place) {
            $oldfilePath = $place->file->filepath;
            
            $validatedData = $request->validate([
            'upload' => 'nullable|mimes:gif,jpeg,jpg,png|max:1024'
        ]);
            if ($request->hasFile('upload')){
            $upload = $request->file('upload');
            $fileName = $upload->getClientOriginalName();
            $fileSize = $upload->getSize();
            $uploadName = time() . '_' . $fileName;
            $filePath = $upload->storeAs(
                'uploads',      // Path
                $uploadName ,   // Filename
                'public'        // Disk
            );
            
            if (\Storage::disk('public')->exists($filePath)) {
                $fullPath = \Storage::disk('public')->path($filePath);
                $place->file->update([
                'filepath' => $filePath,
                'filesize' => $fileSize,
                ]);
                \Storage::disk('public')->delete($oldfilePath);
                $file_id = File::where('filepath',$filePath)->where('filesize',$fileSize)->first();
                if ($file_id){
                $place->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                    'file_id' => $file_id->id,
                    'latitude' => $request->input('latitude'),
                    'longitude' => $request->input('longitude'),
                    'author_id' => $request->input('author_id'),
                ]);
                return response()->json([
                    'success' => true,
                    'data' => $place,
                ], 200);
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error creating file'
                ], 500);
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
                    'author_id' => $request->input('author_id'),
                ]);
                return response()->json([
                    'success' => true,
                    'data' => $place,
                ], 200);
            } else {
                return response()->json([
                    'success'  => false,
                    'message' => 'Error editing place'
                ], 500);
            }
        }
        }else {
            return response()->json([
                'success'  => false,
                'message' => 'Error finding place'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $place = Place::find($id);

        if ($place) {
            $file = File::find($place->file_id);
            $place->delete();
            $file->diskDelete();
            $file->delete();

            return response()->json([
                'success' => true,
                'data' => $place,
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
}
