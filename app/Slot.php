<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    public function applications()
    {
        return $this->hasMany('App\Application');
    }
}
