<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('contacts')->insert([
            'id' => 1,
            'name' => 'Badru Mirajudin',
            'email' => 'info@expose.com',
            'no_hp' => '082120178464',
            'no_telp' => '-',
            'address' => 'Bandung',
        ]);
    }
}
