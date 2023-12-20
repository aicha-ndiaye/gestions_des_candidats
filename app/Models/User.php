<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use App\Models\Formation;
use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'nom',
    //     'prenom',
    //     'email',
    //     'password',
    //     'motivation',
    //     'competence'
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }


    public function candidature()
    {
        return $this->belongsTo(candidature::class);
    }



    public function isAdmin()
    {

        return $this->roles->contains('nomRole', 'admin');
    }
    public function formation()
    {
        // Si l'utilisateur a plusieurs formations, utilisez hasMany
        return $this->hasMany(Formation::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_users');
    }

}
