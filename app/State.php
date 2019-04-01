<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    //
    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }
}
