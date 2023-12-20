@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of all Job Listing
	</div>
	<div class="card-body">

		@if(Session::has('success-msg'))
		<div class="card bg-success text-white shadow mb-2">
            <div class="card-body">
                {{ Session::get('success-msg') }}
            </div>
        </div>
        @endif

		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Date Applied</th>
				<th>Job Title</th>
				<th>Description</th>
				<th>Salary</th>
				<th>Status</th>
			</tr>
			@php($i = ($applications->currentPage() - 1) * $applications->perPage())
			@foreach($applications as $application)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $application->created_at->format('d/m/Y') }}</td>
				<td>{{ $application->job->title }}</td>
				<td>{{ $application->job->description }}</td>
				<td>RM {{ $application->job->salary }}</td>
				<td>
					@if($application->status == 0)
						<span class="badge badge-danger">New</span>
					@elseif($application->status == 1)
						<span class="badge badge-warning">Viewed</span>
					@elseif($application->status == 2)
						<span class="badge badge-primary">Shortlisted</span>
					@elseif($application->status == 3)
						<span class="badge badge-info">Interview</span>
					@elseif($application->status == 4)
						<span class="badge badge-success">Success</span>
					@elseif($application->status == 5)
						<span class="badge badge-warning">KIV</span>
					@else
						<span class="badge badge-danger">Rejected</span>
					@endif
				</td>
			</tr>
			@endforeach
		</table>

		{!! $applications->appends($_GET)->render() !!}
	</div>
</div>
@endsection