@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		Application Details
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

        @php($route = route('employer.application.update', $application->id))
        @php($method = 'PUT')

		<form method="POST" action="{{ $route }}">
		<input type="hidden" name="_method" value="{{ $method }}">
		@csrf

			<div class="form-group">
				<label>Remark</label>
				<textarea name="remark" class="form-control" rows="5">{{ old('remark', $application->remark) }}</textarea>
				@error('remark')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Status</label>
				<select name="status" class="form-control">
					<option value="0" @if(old('status', $application->status) == 0) selected @endif>New</option>
					<option value="1" @if(old('status', $application->status) == 1) selected @endif>Viewed</option>
					<option value="2" @if(old('status', $application->status) == 2) selected @endif>Shortlisted</option>
					<option value="3" @if(old('status', $application->status) == 3) selected @endif>Interview</option>
					<option value="4" @if(old('status', $application->status) == 4) selected @endif>Success</option>
					<option value="5" @if(old('status', $application->status) == 5) selected @endif>KIV</option>
					<option value="6" @if(old('status', $application->status) == 6) selected @endif>Rejected</option>
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