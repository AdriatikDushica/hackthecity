<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['text', 'user_id', 'location_id'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function location()
    {
        return $this->belongsTo('\App\Location');
    }
}
