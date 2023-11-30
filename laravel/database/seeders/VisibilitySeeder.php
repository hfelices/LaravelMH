<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Visibility;
class VisibilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vis = new Visibility([
            'name'      => 'public',
        ]);
        $vis->save();

        $vis = new Visibility([
            'name'      => 'contacts',
        ]);
        $vis->save();

        $vis = new Visibility([
            'name'      => 'private',
        ]);
        $vis->save();
    }
}
