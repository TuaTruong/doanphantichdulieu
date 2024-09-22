<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class League extends Model
{
    use HasFactory;

    public function clubs():HasMany{
        return $this->hasMany(Club::class);
    }

    public function matches():HasMany{
        return $this->hasMany(Matches::class);
    }
}
