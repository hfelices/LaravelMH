<?php

namespace App\Filament\Resources\PlaceResource\Pages;

use App\Filament\Resources\PlaceResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\File;

class CreatePlace extends CreateRecord
{
    protected static string $resource = PlaceResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        \Log::debug("Mutate create form with file relationship");
        // Store file
        //dd($this->data);
        $filepath = array_values($this->data['file']['file_id'])[0];
        $filesize = \Storage::disk('public')->size($filepath);
        $file = File::create([
            'filepath' => $filepath,
            'filesize' => $filesize
        ]);
        // Store file id
        $data['file_id'] = $file->id;
 
 
        return $data;
    }
 
}
