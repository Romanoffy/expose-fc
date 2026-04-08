<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('news_categories')->insert([
            'id' => 1,
            'name' => 'Club News',
        ]);

        DB::table('news_categories')->insert([
            'id' => 2,
            'name' => 'Media Center',
        ]);
        
        DB::table('news_categories')->insert([
            'id' => 3,
            'name' => 'Video',
        ]);

        DB::table('news_categories')->insert([
            'id' => 4,
            'name' => 'RSS',
        ]);
    }
}
