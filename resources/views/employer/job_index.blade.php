@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of all Job Listing
	</div>
	<div class="card-body">

		<a href="{{ route('employer.job.create') }}" class="btn btn-primary">Add Job</a>

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
				<th>Job Title</th>
				<th>Description</th>
				<th>Salary</th>
				<th>Type</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			@php($i = 0)
			@foreach($jobs as $job)
			<tr>
				<td>{{ ++$i }}</td>
				<td>{{ $job->title }}</td>
				<td>{{ $job->description }}</td>
				<td>RM {{ $job->salary }}</td>
				<td></td>
				<td>
					@if($job->status == 1)
						Active
					@else
						Inactive
					@endif
				</td>
				<td> 
					<form method="POST" action="{{ route('employer.job.destroy', $job->id) }}">
						<input type="hidden" name="_method" value="DELETE">
						@csrf
						<a href="{{ route('employer.job.edit', $job->id) }}" class="btn btn-sm btn-primary">Edit</a>
						<button type="submit" class="btn btn-sm btn-danger">Delete</button>
					</form>
				</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>
@endsection