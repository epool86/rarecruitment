@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				My Resume
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
						<td>Photo</td>
						<td>
							@if($profile->photo)
								<img src="{{ asset($profile->photo) }}">
							@else
								No Photo
							@endif
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td>{{ $user->name }}</td>
					</tr>
					<tr>
						<td>Email</td>
						<td>{{ $user->email }}</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>{{ $user->phone }}</td>
					</tr>
					<tr>
						<td>Education History</td>
						<td>{{ $profile->education }}</td>
					</tr>
					<tr>
						<td>Experience</td>
						<td>{{ $profile->experience }}</td>
					</tr>
					<tr>
						<td>Skills</td>
						<td>{{ $profile->skill }}</td>
					</tr>
					<tr>
						<td>Resume</td>
						<td>
							@if($profile->resume)
								<a href="{{ asset('uploads/resume/'.$profile->resume) }}">Download Resume</a>
							@endif
						</td>
					</tr>
				</table>

				<a href="{{ route('applicant.resume.edit') }}" class="btn btn-primary">Update Profile</a>

			</div>
		</div>
	</div>
</div>
@endsection