<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Formation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function candidature()
    {
        return $this->belongsToMany(candidature::class);
    }
   


}
