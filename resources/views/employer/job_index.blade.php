@extends('layouts.master')

@section('content')
<div class="card">
	<div class="card-header">
		List of all Job Listing
	</div>
	<div class="card-body">
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
			<tr>
				<td>1</td>
				<td>Job Title</td>
				<td></td>
				<td>RM 0.00</td>
				<td>Contract</td>
				<td>Aktif</td>
				<td> 
					<a href="" class="btn btn-sm btn-primary">Edit</a>
					<a href="" class="btn btn-sm btn-danger">Delete</a>
				</td>
			</tr>
		</table>
	</div>
</div>
@endsection