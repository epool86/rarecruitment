<html>
<body>

	<h1>All Application List</h1>

	<table>
		<tr>
			<th style="border:1px solid #000000; background: #EEEEEE; font-weight: bold; width: 5">#</th>
			<th style="border:1px solid #000000; background: #EEEEEE; font-weight: bold; width: 10">Date Applied</th>
			<th style="border:1px solid #000000; background: #EEEEEE; font-weight: bold; width: 30">Candidate Name</th>
			<th style="border:1px solid #000000; background: #EEEEEE; font-weight: bold; width: 20">Photo</th>
			<th style="border:1px solid #000000; background: #EEEEEE; font-weight: bold; width: 20">Resume</th>
			<th style="border:1px solid #000000; background: #EEEEEE; font-weight: bold; width: 10">Status</th>
		</tr>
		@php($i = 0)
		@foreach($applications as $application)
		<tr>
			<td>{{ ++$i }}</td>
			<td>{{ $application->created_at->format('d/m/Y') }}</td>
			<td>{{ $application->user->name }}</td>
			<td>
				@if($application->user->profile)
					@if($application->user->profile->photo)
						<img src="uploads/photo/thumbnail_{{ $application->user->profile->photo }}" width="50">
					@endif
				@endif
			</td>
			<td>
				@if($application->user->profile)
					@if($application->user->profile->resume)
						<a href="{{ asset('uploads/resume/'.$application->user->profile->resume) }}">Download</a>
					@endif
				@endif
			</td>
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

</body>

</html>