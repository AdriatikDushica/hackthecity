<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = ['name'];

    public function locations()
    {
        return $this->hasMany('\App\Location');
    }
}
