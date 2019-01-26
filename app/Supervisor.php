<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supervisor extends Model
{
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
