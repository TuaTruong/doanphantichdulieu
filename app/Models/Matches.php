<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Matches extends Model
{
    use HasFactory;
    protected $table = 'matches';
    protected $fillable = ['league_id','start_time','team_home_id','team_away_id'];

    public function statistics(){
        return $this->hasMany(Statistic::class, "match_id",'id');
    }

    public function cornerOdd()
    {
        return $this->hasMany(CornerOdd::class, "match_id",'id');
    }

    public function league(){
        return $this->belongsTo(League::class,'league_id','id');
    }

    public function teamHome(){
        return $this->hasOne(Club::class,'id','team_home_id');
    }

    public function teamAway(){
        return $this->hasOne(Club::class,'id','team_away_id');
    }
}
