<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function users()
{
    return $this->belongsToMany(User::class);
}

    public function hasRole($role)
{
    return $this->roles()->where('nomRole', $role)->exists();
}
}
