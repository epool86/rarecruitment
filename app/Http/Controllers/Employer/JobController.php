<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

use App\Models\Job;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $jobs = Job::where('user_id', $user->id)->get();
        return view('employer.job_index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $job = new Job;
        $job->status = 1;
        return view('employer.job_form', compact('job'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $job = new Job;
        $user = Auth::user();

        $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable',
            'close_date' => 'nullable|date_format:Y-m-d',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $job->user_id = $user->id;
        $job->title = $request['title'];
        $job->description = $request['description'];
        $job->close_date = $request['close_date'];
        $job->salary = $request['salary'];
        $job->status = $request['status'];
        $job->save();

        Session()->flash('success-msg', 'New job has been added.');
        return redirect()->route('employer.job.index');
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
    public function edit(Job $job)
    {
        if($job->user_id != Auth::user()->id){
            abort(404);
        }
        return view('employer.job_form', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        if($job->user_id != Auth::user()->id){
            abort(404);
        }

        $user = Auth::user();

        $this->validate($request, [
            'title' => 'required',
            'description' => 'nullable',
            'close_date' => 'nullable|date_format:Y-m-d',
            'salary' => 'required|numeric|min:0',
            'status' => 'required|in:0,1',
        ]);

        $job->user_id = $user->id;
        $job->title = $request['title'];
        $job->description = $request['description'];
        $job->close_date = $request['close_date'];
        $job->salary = $request['salary'];
        $job->status = $request['status'];
        $job->save();

        Session()->flash('success-msg', 'Job has been updated.');
        return redirect()->route('employer.job.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if($job->user_id != Auth::user()->id){
            abort(404);
        }
        
        $job->delete();

        Session()->flash('success-msg', 'Job has been deleted.');
        return redirect()->route('employer.job.index');
    }
}
