<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    public function module()
    {
        return $this->belongsTo('App\Module');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
