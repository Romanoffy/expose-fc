<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuCategory;

class MenuCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            'internal' => [
                ['event_name' => 'Liga Expose', 'description' => 'Kompetisi internal antar divisi atau tim internal'],
                ['event_name' => 'Festival Expose', 'description' => 'Festival olahraga dan seni internal perusahaan'],
            ],
            'external' => [
                ['event_name' => 'BPL', 'description' => 'Bola Pemuda League'],
                ['event_name' => 'LBFF', 'description' => 'Liga Bola Futsal Favorit'],
                ['event_name' => 'SATURDAY LEAGUE', 'description' => 'Liga akhir pekan untuk komunitas'],
                ['event_name' => 'INDIE FOOTBALL', 'description' => 'Turnamen sepak bola independen'],
            ],
            'friendly' => [
                ['event_name' => 'Friendly Match', 'description' => 'Pertandingan persahabatan antar tim'],
                ['event_name' => 'Trofeo', 'description' => 'Turnamen trofi persahabatan'],
                ['event_name' => 'Fourfeo', 'description' => 'Turnamen futsal 4v4 persahabatan'],
            ],
        ];

        foreach ($events as $category => $eventList) {
            foreach ($eventList as $event) {
                MenuCategory::create([
                    'category' => $category,
                    'event_name' => $event['event_name'],
                    'description' => $event['description'],
                ]);
            }
        }
    }
}