<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOption;

class Standings extends Model
{
    protected $table = 'standings';
    use HasFactory;
    // Disable automatic timestamp management
    public $timestamps = false;

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'team_id',
        'win',
        'draw',
        'lose',
        'goal_for',
        'goal_against',
        'goal_difference',
        'point',
    ];

    public static function index()
    { 
        return Standings::leftJoin('teams', 'teams.id', '=', 'standings.team_id')
        ->orderBy('point','desc')
        ->orderBy('goal_difference', 'desc')
        ->orderBy('goal_for', 'desc')
        ->orderBy('goal_against', 'desc')
        ->get();
    }


}