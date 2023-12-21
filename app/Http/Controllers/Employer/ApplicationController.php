<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonImmutable;

use Auth;
use PDF;
use Excel;
use DB;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;

use App\Exports\ExportApplication;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $job_id = isset($_GET['job_id']) ? $_GET['job_id'] : 'ALL';
        $status = isset($_GET['status']) ? $_GET['status'] : 'ALL';
        $month = isset($_GET['month']) ? $_GET['month'] : date('n');
        $year = isset($_GET['year']) ? $_GET['year'] : date('Y');

        $jobs = Job::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->get();

        $applications = Application::query();

        if($job_id != 'ALL'){
            $applications = $applications->where('job_id', $job_id);
        }

        if($status != 'ALL'){
            $applications = $applications->where('status', $status);
        }

        if($month != 'ALL'){
            $applications = $applications->whereMonth('created_at', $month);
        }

        if($year != 'ALL'){
            $applications = $applications->whereYear('created_at', $year);
        }

        //$applications->where('created_at', $date); //exact date
        //$applications->where('created_at', '>=', $date_from)->where('created_at', '<=', $date_to) //date range

        $applications = $applications->paginate(3);

        return view('employer.application_index', compact('jobs', 'applications','job_id','status','month','year'));
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

    public function export(){

        $job_id = isset($_GET['job_id']) ? $_GET['job_id'] : Job::where('user_id', Auth::user()->id)->orderBy('title', 'ASC')->first()->id;
        $status = isset($_GET['status']) ? $_GET['status'] : 0;
        $applications = Application::where('job_id', $job_id)->where('status', $status)->get();

        $pdf = PDF::loadView('employer.application_pdf', compact('applications'));
        return $pdf->download('application_list.pdf');

    }

    public function exportExcel(){

        return Excel::download(new ExportApplication, 'application_list.xlsx');

    }

    public function summary(){

        $user = Auth::user();

        $total_candidate = User::where('role', 'applicant')->count();
        $total_application = Application::whereHas('job', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->count();
        $total_job = Job::where('user_id', $user->id)->count();
        $total_active_job = Job::where('user_id', $user->id)->where('status', 1)->count();
        $total_inactive_job = Job::where('user_id', $user->id)->where('status', 0)->count();

        $data = Application::whereHas('job', function($q) use ($user){
            $q->where('user_id', $user->id);
        })->select(
            DB::raw('count(id) as `total`'),
            DB::raw("DATE_FORMAT(created_at, '%M %Y') as `month`"),
            DB::raw("DATE_FORMAT(created_at, '%m') as `index`"),
        )->groupBy('month','index')->get()->toArray();

        $data_complete = [];

        for($i = 1; $i <= 12; $i++){

            $data_complete[$i]['legend'] = date("M Y", mktime(0,0,0,$i,1));
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);

            if(array_search($month, array_column($data, 'index')) === false){

                $data_complete[$i]['total'] = 0;

            } else {

                $key = array_search($month, array_column($data, 'index'));
                $data_complete[$i]['total'] = $data[$key]['total'];

            }

        }

        $array = [];
        //$today = CarbonImmutable::today();
        $today = CarbonImmutable::createFromFormat('d/m/Y', '01/02/2024');

        for($i = 0; $i < 12; $i++){
            $date = $today->subMonths($i);
            $array[$i]['label'] = $date->format("F Y");

            $total = Application::whereMonth('created_at', $date->format('n'))->whereYear('created_at', $date->format('Y'))->count();
            $array[$i]['total'] = $total;
        }

        dd($array);

        return view('employer.application_summary', compact('total_candidate', 'total_application', 'total_job', 'total_active_job','total_inactive_job', 'data_complete'));

    }

    public function ajax(){

        $senarai = $_GET['val'];

        $previous_senarai = \Session::get('selectedArray') ? \Session::get('selectedArray') : [];

        if(!in_array($senarai, $previous_senarai))
        {
            $previous_senarai[] = $senarai; 
        }

        \Session::put('selectedArray', $previous_senarai);

    }
}
