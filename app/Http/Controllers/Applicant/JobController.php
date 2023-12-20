<?php

namespace App\Http\Controllers\Applicant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Job;

class JobController extends Controller
{
    public function search(){

        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : null;

        if($keyword){

            $jobs = Job::where('status',1)->where(function($q) use ($keyword){

                $q->where('title', 'LIKE', '%'.$keyword.'%');
                $q->orWhere('description', 'LIKE', '%'.$keyword.'%');
                $q->orWhereHas('user', function($q) use ($keyword){
                    $q->where('name', 'LIKE', '%'.$keyword.'%');
                    $q->orWhere('email', 'LIKE', '%'.$keyword.'%');
                });

            })->orderBy('created_at','DESC')->paginate(3);

        } else {

            $jobs = Job::where('status',1)->orderBy('created_at','DESC')->take(5)->paginate(5);

        }

        return view('applicant.search', compact('jobs','keyword'));
    }

    public function history(){

    }
}
