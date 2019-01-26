<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }
    public function slot()
    {
        return $this->belongsTo('App\Slot');
    }
}
