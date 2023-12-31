<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class candidature extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function candidature()
    {
        return $this->belongsTo(User::class);
    }
    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }
}
