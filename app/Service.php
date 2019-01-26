<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }
}
