@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		Job Details
	</div>
	<div class="card-body">

		@if($errors->any())
		@foreach($errors->all() as $error)
		<div class="card bg-danger text-white mb-2">
            <div class="card-body">
                {{ $error }}
            </div>
        </div>
        @endforeach
        @endif

        @if($job->id)
        	@php($route = route('employer.job.update', $job->id))
        	@php($method = 'PUT')
        @else
        	@php($route = route('employer.job.store'))
        	@php($method = 'POST')
        @endif
		
		<form method="POST" action="{{ $route }}">
		<input type="hidden" name="_method" value="{{ $method }}">
		@csrf

			<div class="form-group">
				<label>Job Title</label>
				<input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}">
				@error('title')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Job Description</label>
				<textarea name="description" class="form-control" rows="5">{{ old('description', $job->description) }}</textarea>
				@error('description')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Close Date</label>
				<input type="date" name="close_date" class="form-control" value="{{ old('close_date', $job->close_date) }}">
				@error('close_date')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Salary (RM)</label>
				<input type="text" name="salary" class="form-control" value="{{ old('salary', $job->salary) }}">
				@error('salary')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Status</label>
				<select name="status" class="form-control">
					<option value="1" @if(old('status', $job->status) == 1) selected @endif>Active</option>
					<option value="0" @if(old('status', $job->status) == 0) selected @endif>Inactive</option>
				</select>
				@error('status')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Save</button>
			</div>

		</form>

	</div>
</div>
@endsection