<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Localisation extends Model
{
    protected $fillable = ["pays" , "ville" , "rue" , "code_postal"];

    public function user () {
        return $this->belongsTo(User::class);
    }
}
