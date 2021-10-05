@extends('layouts.master')
@section('register')
	<div class="large-12 medium-12 small-12 column register">
		<div class="large-6 medium-6 small-12 column">
			<h2>Register</h2>
			<div class="panel-body">
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">Username</label>

						<div class="col-md-6">
							<input type="text" class="form-control" name="username" value="{{ old('username') }}">
							
							@if (count($errors) > 0)
								@foreach ($errors->get('username') as $error)
									<span class="error">{{ $error }}</span>
								@endforeach
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">E-Mail Address</label>

						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">
							
							@if (count($errors) > 0)
								@foreach ($errors->get('email') as $error)
									<span class="error">{{ $error }}</span>
								@endforeach
							@endif
						</div>
					</div>
					
					<div>
						<span class="prefix"><strong>User Type</strong></span>
						<div>
							Company <input type="radio" name="user_type_id" value="1" />
							Group <input type="radio" name="user_type_id" value="2" />
							Individual <input type="radio" name="user_type_id" value="3" />
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('user_type_id') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">Password</label>

						<div class="col-md-6">
							<input type="password" class="form-control" name="password">
							
							@if (count($errors) > 0)
								@foreach ($errors->get('password') as $error)
									<span class="error">{{ $error }}</span>
								@endforeach
							@endif
						</div>
					</div>
					
					<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">Confirm Password</label>

						<div class="col-md-6">
							<input type="password" class="form-control" name="password_confirmation">
							
							@if (count($errors) > 0)
								@foreach ($errors->get('password_confirmation') as $error)
									<span class="error">{{ $error }}</span>
								@endforeach
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="large expanded button">
								<i class="fa fa-btn fa-user"></i>Register
							</button>
						</div>
					</div>
				</form>
			</div>
        </div>
		<div class="large-6 medium-6 small-12 social-login column">
			<div class="large-12 medium-12 small-12 facebook-login column">
				<a class="large expanded button" href="{{ route('social-login', 'facebook') }}" style="background-color: #395387; border-color: #395387;">Facebook Login</a>
			</div>
			<div class="large-12 medium-12 small-12 google-login column">
				<a class="large expanded button" href="{{ route('social-login', 'google') }}" style="background-color: #dd4b39; border-color: #dd4b39;">Google+ Login</a>
			</div>
			<div class="large-12 medium-12 small-12 twitter-login column">
				<a class="large expanded button" href="{{ route('social-login', 'twitter') }}" style="background-color: #5ea9dd; border-color: #5ea9dd;">Twitter Login</a>
			</div>
		</div>
    </div>
@endsection
