<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $place = new Place([
            'name' => 'place1',
            'description' => 'lorem ipsum dolor sit amet',
            'file_id' => '1',
            'latitude' => '1',
            'longitude'=> '1',
            'visibility_id' => '1',
            'author_id' => '1'
        ]);
        $place->save();
        $place = new Place([
            'name' => 'place2',
            'description' => 'lorem ipsum dolor sit amet',
            'file_id' => '2',
            'latitude' => '2',
            'longitude'=> '2',
            'visibility_id' => '1',
            'author_id' => '1'
        ]);
        $place->save();
    }
}
