<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function service()
    {
        return $this->belongsTo('App\Service');
    }
    public function supervisor()
    {
        return $this->belongsTo('App\Supervisor');
    }
    public function state()
    {
        return $this->belongsTo('App\State');
    }
    public function department()
    {
        return $this->belongsTo('App\Department');
    }
    public function samples()
    {
        return $this->hasMany('App\Sample');
    }
    public function applications()
    {
       return $this->hasMany('App\Application');
    }
}
