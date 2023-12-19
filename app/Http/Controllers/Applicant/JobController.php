<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Job;

class JobController extends Controller
{
    public function search(){

        $jobs = Job::where('status',1)->orderBy('created_at','DESC')->take(5)->get();
        return view('applicant.search', compact('jobs'));
    }

    public function history(){

    }
}
