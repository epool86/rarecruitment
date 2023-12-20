<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function job(){
        return $this->belongsTo('App\Models\Job');
    }
}
