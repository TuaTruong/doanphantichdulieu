<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proxy extends Model
{
    use HasFactory;
    protected $fillable = ["username","password","ip","port","is_live"];

    // Hàm tạo proxy URL
    public function getProxyUrl()
    {
        if ($this->username && $this->password) {
            return "http://{$this->username}:{$this->password}@{$this->ip}:{$this->port}";
        }

        return "http://{$this->ip}:{$this->port}";
    }
}
