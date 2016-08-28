<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'google', 'twitter', 'instagram',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'google', 'twitter', 'instagram'
    ];

    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    public function likes()
    {
        return $this->belongsToMany('\App\Location');
    }

    public function comments()
    {
        return $this->hasMany('\App\Comment');
    }

    public function notifications()
    {
        return $this->hasMany('\App\Notification');
    }
}
