<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $post = new Post([
            'body' => 'lorem ipsum dolor sit amet',
            'file_id' => '3',
            'latitude' => '3',
            'longitude'=> '3',
            'visibility_id' => '1',
            'author_id' => '1'
        ]);
        $post->save();
        $post = new Post([
            'body' => 'lorem ipsum dolor sit amet',
            'file_id' => '4',
            'latitude' => '4',
            'longitude'=> '4',
            'visibility_id' => '1',
            'author_id' => '1'
        ]);
        $post->save();
    }
}
