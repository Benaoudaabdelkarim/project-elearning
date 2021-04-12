<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Slide extends Model
{
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
