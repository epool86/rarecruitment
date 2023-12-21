<html>
<head>
	<style type="text/css">
		.table {
			width: 100%;
			border: 1px solid #000;
		}
		.table th {
			background-color: #DDD;
			padding: 5px;
			border: 1px solid #999;
		}
		.table td {
			padding: 5px;
			border: 1px solid #999;
		}
	</style>
</head>
<body>
	<table class="table" cellpadding="0" cellspacing="0">
		<tr>
			<th>#</th>
			<th>Date Applied</th>
			<th>Candidate Name</th>
			<th>Photo</th>
			<th>Resume</th>
			<th>Status</th>
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
						<img src="{{ asset('uploads/photo/thumbnail_'.$application->user->profile->photo) }}">
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