<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Players extends Model
{
    protected $table = 'players';
    use HasFactory;
    // use HasSlug;

    // public static function index($search = '')
    // {

    //     return Kursus::select("kursus.*","kategori_kursus.nama as nama_kategori_kursus")
    //     ->leftJoin('kategori_kursus', 'kategori_kursus.id', '=', 'kursus.id_kategori_kursus')
    //     ->orderBy('tanggal_mulai', 'desc')
    //     ->when ($search, function ($query, $search) {
    //         return $query->where('nama', 'like', "%" . $search . "%");
    //     });
    // }

    public static function index($search = '')
    { 
        
        return Players::select("players.*","teams.name as team_name")
            ->leftJoin('teams', 'teams.id', '=', 'players.team_id')
            ->orderBy('name','asc')
        ->when($search, function($query, $search){
            return $query->where('name','like',"%". $search . "%");
        });
    }


    public function team_id()
    {
        return $this->belongsTo(Teams::class, 'team_id');
    }

    public function player_position()
    {
        return $this->hasManyThrough(Positions::class, PlayersPositions::class, 'position_id');
    }
}