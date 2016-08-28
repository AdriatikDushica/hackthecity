<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['notified', 'user_id', 'from_user_id', 'location_id', 'type'];

    public function user()
    {
        return $this->belongsTo('\App\User');
    }

    public function userFrom()
    {
        return $this->belongsTo('\App\User', 'from_user_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo('\App\Location');
    }
}
