<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Auth;

use App\Models\Application;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function checkApply(){

        $user_id = Auth::user()->id;
        $job_id = $this->id;

        return Application::where('user_id', $user_id)->where('job_id', $job_id)->count();

    }

    public function countCandidate(){

        return Application::where('job_id', $this->id)->count();
        
    }

}
