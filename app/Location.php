<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['path', 'description', 'lat', 'lng', 'disabled'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
