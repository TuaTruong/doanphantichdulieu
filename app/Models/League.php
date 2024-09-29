<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;
    protected $fillable = ["name"];

    public function clubs():BelongsToMany{
        return $this->belongsToMany(Club::class,'club_league');
    }

    public function matches():HasMany{
        return $this->hasMany(Matches::class);
    }
}
