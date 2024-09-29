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
        return $this->hasMany(Statistic::class, 'match_id');
    }
}
