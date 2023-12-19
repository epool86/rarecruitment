@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">

		@if(Session::has('success-msg'))
		<div class="card bg-success text-white shadow mb-2">
            <div class="card-body">
                {{ Session::get('success-msg') }}
            </div>
        </div>
        @endif

		<form method="POST" action="{{ route('account.post') }}">
		@csrf

			<div class="form-group">
				<label>Name</label>
				<input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
				@error('name')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Email</label>
				<input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}">
				@error('email')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control">
				@error('password')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" name="password_confirmation" class="form-control">
				@error('password_confirmation')
					<span class="text-danger">{{ $message }}</span>
				@enderror
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-primary">Update Profile</button>
			</div>

		</form>

	</div>
</div>
@endsection