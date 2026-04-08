<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('positions')->insert([
            'id' => 1,
            'name' => 'Goal Keeper (GK)',
        ]);

        DB::table('positions')->insert([
            'id' => 2,
            'name' => 'Center Back (CB)',
        ]);

        DB::table('positions')->insert([
            'id' => 3,
            'name' => 'Right Center Back (RCB)',
        ]);

        DB::table('positions')->insert([
            'id' => 4,
            'name' => 'Left Center Back (LCB)',
        ]);

        DB::table('positions')->insert([
            'id' => 5,
            'name' => 'Right Back (RB)',
        ]);

        DB::table('positions')->insert([
            'id' => 6,
            'name' => 'Left Back (LB)',
        ]);

        DB::table('positions')->insert([
            'id' => 7,
            'name' => 'Right Wing Back (RWB)',
        ]);

        DB::table('positions')->insert([
            'id' => 8,
            'name' => 'Left Wing Back (LWB)',
        ]);

        DB::table('positions')->insert([
            'id' => 9,
            'name' => 'Defender Midfielder (DM)',
        ]);

        DB::table('positions')->insert([
            'id' => 10,
            'name' => 'Center Midfielder (CM)',
        ]);

        DB::table('positions')->insert([
            'id' => 11,
            'name' => 'Right Midfielder (RM)',
        ]);

        DB::table('positions')->insert([
            'id' => 12,
            'name' => 'Left Midfielder (LM)',
        ]);

        DB::table('positions')->insert([
            'id' => 13,
            'name' => 'Attacking Midfielder (AM)',
        ]);


        DB::table('positions')->insert([
            'id' => 14,
            'name' => 'Right Forward (RF)',
        ]);

        DB::table('positions')->insert([
            'id' => 15,
            'name' => 'Left Forward (LF)',
        ]);

        DB::table('positions')->insert([
            'id' => 16,
            'name' => 'Second Striker (SS)',
        ]);

        DB::table('positions')->insert([
            'id' => 17,
            'name' => 'Center Forward (CF)',
        ]);
    }
}
