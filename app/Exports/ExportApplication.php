<?php

namespace App\Exports;

use App\Models\Application;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportApplication implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View 
    {
        $applications = Application::all();

        return view('employer.application_excel', compact('applications'));

        /***
        $applications = Application::all();

        foreach($applications as $application){
            $application->user_id = $application->user->name;
            $application->job_id = $application->job->title;
            if($application->status == 0){
                $application->status = "New";
            }elseif($application->status == 1){
                $application->status = "Viewed";
            }elseif($application->status == 2){
                $application->status = "Shortlisted";
            }elseif($application->status == 3){
                $application->status = "Interview";
            }
        }

        return $applications;
        ***/
    }
}
