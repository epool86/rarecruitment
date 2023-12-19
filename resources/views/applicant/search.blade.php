@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="text-center" style="padding: 50px 200px;">
			<table class="w-100">
				<tr>
					<td>
						<input type="text" class="form-control" name="">
					</td>
					<td>
						<button type="btn" class="btn btn-primary w-100" name="">
							Search Job
						</button>
					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">

		@foreach($jobs as $job)
		<div style="border:1px solid #999; background-color:#FFF; padding: 20px; margin-bottom: 10px;">
			<div style="font-weight:bold;">{{ $job->title }}</div><br>
			{{ $job->description }}<br>
			Salary: RM {{ $job->salary }}
			Closing Date: {{ $job->close_date }}<br>
			<a href="" class="btn btn-primary">Apply Job</a>
		</div>
		@endforeach

	</div>
</div>
@endsection