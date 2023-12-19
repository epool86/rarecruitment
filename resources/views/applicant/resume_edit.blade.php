@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				My Resume
			</div>
			<div class="card-body">
				
				<form method="POST" action="{{ route('applicant.resume.post') }}" enctype="multipart/form-data">
				@csrf
				<table class="table">
					<tr>
						<td>Photo</td>
						<td>
							<input type="file" class="form-control" name="photo">
							@error('photo')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>
							<input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
							@error('phone')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</td>
					</tr>
					<tr>
						<td>Education History</td>
						<td>
							<textarea name="education" class="form-control" rows="6">{{ old('education', $profile->education) }}</textarea>
							@error('education')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</td>
					</tr>
					<tr>
						<td>Experience</td>
						<td>
							<textarea name="experience" class="form-control" rows="6">{{ old('experience', $profile->experience) }}</textarea>
							@error('experience')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</td>
					</tr>
					<tr>
						<td>Skills</td>
						<td>
							<input type="text" name="skill" class="form-control" value="{{ old('skill', $profile->skill) }}">
							@error('skill')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</td>
					</tr>
					<tr>
						<td>Resume</td>
						<td>
							<input type="file" name="resume" class="form-control">
							@error('resume')
								<span class="text-danger">{{ $message }}</span>
							@enderror
						</td>
					</tr>
				</table>

				<a href="{{ route('applicant.resume.show') }}" class="btn btn-primary">Cancel</a>
				<button type="submit" class="btn btn-primary">Save</button>

				</form>

			</div>
		</div>
	</div>
</div>
@endsection