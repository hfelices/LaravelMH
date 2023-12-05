<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\File;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = new File([
            'filepath'      => 'uploads/imagen.png',
            'filesize'     => '111',
        ]);
        $file->save();
        $file = new File([
            'filepath'      => 'uploads/imagen.png',
            'filesize'     => '111',
        ]);
        $file->save();
        $file = new File([
            'filepath'      => 'uploads/imagen.png',
            'filesize'     => '111',
        ]);
        $file->save();
        $file = new File([
            'filepath'      => 'uploads/imagen.png',
            'filesize'     => '111',
        ]);
        $file->save();
    }
}
