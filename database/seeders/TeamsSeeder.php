<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teams')->insert([
            'id' => 1,
            'logo' => 'logoteam1.png',
            'name' => 'Expose FC',
            'descriptions' =>  'Polban bagi kami lebih dari sekedar kampus, yakni sebuah cerita bagaimana impian kami tercetus.
            seringkali orang bertanya apa itu polban? wajar jika mereka termenung | karena lokasi kami di ujung kota bandung.
            Expose adalah cara kami untuk memperkenalkan polban lewat sepakbola.
            Bukan expose jika tidak diisi oleh alumni | kami menyebutnya sebagai | darah murni. 
            Kesamaan nuansa, rasa dan asa berbalut cinta pada sepakbola menjadikan mereka ksatria dewaruga.
            Bersama yang lain, kita akan coba berjuang merebut kembali yang sempat hilang.
            Terima kasih telah setia menjadi ksatria.
            https://www.instagram.com/reel/CupiHbdgsh3/?igshid=MTc4MmM1YmI2Ng=='
        ]);
    }
}
