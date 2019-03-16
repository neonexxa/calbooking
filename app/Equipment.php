<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public function services()
    {
        return $this->hasMany('App\Service');
    }
    public function location()
    {
        return $this->belongsTo('App\Location');
    }
}
