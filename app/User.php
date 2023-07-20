<?php

namespace App;

use App\Models\Positions;
use App\Models\Role;
use App\Models\State;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    public function position()
    {
        return $this->belongsTo(Positions::class);
    }
    public function State()
    {
        return $this->belongsTo(State::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function hasRole()
    {
        return $this->role->name;
    }
}
