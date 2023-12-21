@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of Applications
	</div>
	<div class="card-body">

		@if(Session::has('success-msg'))
		<div class="card bg-success text-white shadow mb-2">
            <div class="card-body">
                {{ Session::get('success-msg') }}
            </div>
        </div>
        @endif

        <div class="row">
        	<div class="col-md-3">
        		<select class="form-control" id="job_id" onchange="filterList()">
        			<option value="ALL" @if($job_id == 'ALL') selected @endif>ALL Jobs</option>
        			@foreach($jobs as $job)
        			<option value="{{ $job->id }}" @if($job_id == $job->id) selected @endif>{{ $job->title }}</option>
        			@endforeach
        		</select>
        	</div>
        	<div class="col-md-3">
        		<select class="form-control" id="status" onchange="filterList()">
        			<option value="ALL" @if($status == 'ALL') selected @endif>ALL Status</option>
        			<option value="0" @if($status == 0) selected @endif>New</option>
        			<option value="1" @if($status == 1) selected @endif>Viewed</option>
        			<option value="2" @if($status == 2) selected @endif>Shortlised</option>
        			<option value="3" @if($status == 3) selected @endif>Interview</option>
        			<option value="4" @if($status == 4) selected @endif>Success</option>
        			<option value="5" @if($status == 5) selected @endif>KIV</option>
        			<option value="6" @if($status == 6) selected @endif>Rejected</option>
        		</select>
        	</div>
        	<div class="col-md-2">
        		<select class="form-control" id="month" onchange="filterList()">
        			<option value="ALL" @if($month == 'ALL') selected @endif>ALL Month</option>
        			<option value="1" @if($month == '1') selected @endif>January</option>
        			<option value="2" @if($month == '2') selected @endif>February</option>
        			<option value="3" @if($month == '3') selected @endif>March</option>
        			<option value="4" @if($month == '4') selected @endif>April</option>
        			<option value="5" @if($month == '5') selected @endif>May</option>
        			<option value="6" @if($month == '6') selected @endif>June</option>
        			<option value="7" @if($month == '7') selected @endif>July</option>
        			<option value="8" @if($month == '8') selected @endif>August</option>
        			<option value="9" @if($month == '9') selected @endif>September</option>
        			<option value="10" @if($month == '10') selected @endif>October</option>
        			<option value="11" @if($month == '11') selected @endif>November</option>
        			<option value="12" @if($month == '12') selected @endif>December</option>
        		</select>
        	</div>
        	<div class="col-md-2">
        		<select class="form-control" id="year" onchange="filterList()">
        			<option value="ALL" @if($year == 'ALL') selected @endif>ALL YEAR</option>
        			<option value="2023" @if($year == '2023') selected @endif>2023</option>
        			<option value="2024" @if($year == '2024') selected @endif>2024</option>
        		</select>
        	</div>
        	<div class="col-md-1">
        		<a href="{{ route('employer.application.export') }}?job_id={{ $job_id }}&status={{ $status }}" class="btn btn-primary w-100">PDF</a>
        	</div>
        	<div class="col-md-1">
        		<a href="{{ route('employer.application.exportExcel') }}" class="btn btn-primary w-100">Excel</a>
        	</div>
        </div>

        <br>

        <form id="borang">
		<table class="table table-bordered">
			<tr>
				<th>#</th>
				<th>Date Applied</th>
				<th>Candidate Name</th>
				<th>Photo</th>
				<th>Resume</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
			@php($i = 0)
			@foreach($applications as $application)
			<tr>
				<td>
					{{ ++$i }}
					<input type="checkbox" name="senarai[]" class="senarai" onchange="" value="{{ $application->id }}" @if(in_array($application->id, Session::get('selectedArray'))) checked @endif>
				</td>
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
				<td> 
					<a href="{{ route('employer.application.edit', $application->id) }}" class="btn btn-sm btn-primary">Edit</a>
				</td>
			</tr>
			@endforeach
		</table>
		</form>

		{!! $applications->appends($_GET)->render() !!}

		{{ var_dump(Session::get('selectedArray')) }}
	</div>
</div>
@endsection

@section('bottom_script')
<script type="text/javascript">
	
	function filterList(){

		var e = document.getElementById("job_id");
		var job_id = e.options[e.selectedIndex].value;

		var e = document.getElementById("status");
		var status = e.options[e.selectedIndex].value;

		var e = document.getElementById("month");
		var month = e.options[e.selectedIndex].value;

		var e = document.getElementById("year");
		var year = e.options[e.selectedIndex].value;

		location.href = "{{ route('employer.application.index') }}?job_id="+job_id+"&status="+status+"&month="+month+"&year="+year;

	}

	$('.senarai').change(function (e) {

		val = $(this).val();
		const checked = $(this).is(':checked');

		if(checked){
		
			$.ajax({
			    url : '{{ route('employer.application.ajax') }}',
			    type : 'GET',
			    data : {
			    	'val': val,
			    },
			    dataType:'json',
			    success : function(data) {              
			        alert('Data: '+data);
			    },
			    error : function(request,error)
			    {
			        alert("Request: "+JSON.stringify(request));
			    }
			});

		}

	});

</script>
@endsection