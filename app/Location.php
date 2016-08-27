<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['path', 'description', 'type_id', 'lat', 'lng', 'disabled'];

    protected $casts = [
        'lat' => 'double',
        'lng' => 'double',
        'disabled' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function type()
    {
        return $this->belongsTo('\App\Type');
    }
}
