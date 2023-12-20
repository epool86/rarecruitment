<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_id = isset($_GET['job_id']) ? $_GET['job_id'] : Job::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->first()->id;

        $status = isset($_GET['status']) ? $_GET['status'] : 0;

        $jobs = Job::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();
        $applications = Application::where('job_id', $job_id)->where('status', $status)->get();

        return view('employer.application_index', compact('jobs', 'applications','job_id','status'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        if($application->status == 0){
            $application->status = 1;
            $application->save();
        }
        return view('employer.application_form', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        $application->remark = $request['remark'];
        $application->status = $request['status'];
        $application->save();

        return redirect()->route('employer.application.index', [
            'job_id' => $application->job_id,
            'status' => $application->status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
