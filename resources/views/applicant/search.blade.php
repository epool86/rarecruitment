@extends('layouts.master')

@section('content')

@if(Session::has('success-msg'))
<div class="card bg-success text-white shadow mb-2">
    <div class="card-body">
        {{ Session::get('success-msg') }}
    </div>
</div>
@endif

<div class="row">
	<div class="col-md-12">
		<div class="text-center" style="padding: 50px 200px;">
			<form method="GET" action="{{ route('applicant.search') }}">
			<table class="w-100">
				<tr>
					<td>
						<input type="text" class="form-control" name="keyword" value="{{ $keyword }}">
					</td>
					<td>
						<button type="submit" class="btn btn-primary w-100">
							Search Job
						</button>
					</td>
				</tr>
			</table>
			</form>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">

		@foreach($jobs as $job)
		<div style="border:1px solid #999; background-color:#FFF; padding: 20px; margin-bottom: 10px;">
			<div style="font-weight:bold;">
				{{ $job->title }} ({{ $job->countCandidate() }} has applied)
			</div>
			<br>
			{{ $job->description }}<br>
			Salary: RM {{ $job->salary }}
			Closing Date: {{ $job->close_date }}<br>
			Post by {{ $job->user->name }}

			@if($job->checkApply() == 0)
			<form method="POST" action="{{ route('applicant.application.store') }}">
				@csrf
				<input type="hidden" name="job_id" value="{{ $job->id }}">
				<button type="submit" class="btn btn-primary">Apply Job</button>
			</form>
			@else
				<br><span class="text-danger">Applied!</span>
			@endif

		</div>
		@endforeach

		<div>
			{!! $jobs->appends($_GET)->render() !!}
		</div>

	</div>
</div>
@endsection