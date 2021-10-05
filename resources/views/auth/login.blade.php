@extends('layouts.master')
@section('login')
	<div class="large-12 medium-12 small-12 column contactus">
		<div class="large-6 medium-6 small-12 column">
			<h2>Login</h2>
			<div class="panel-body">
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">E-Mail Address</label>

						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">

							@if ($errors->has('email'))
								<span class="error">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">Password</label>

						<div class="col-md-6">
							<input type="password" class="form-control" name="password">

							@if ($errors->has('password'))
								<span class="error">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember"> Remember Me
								</label>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="large expanded button">
								<i class="fa fa-btn fa-sign-in"></i>Login
							</button>

							<a class="btn btn-link" href="{{ url('/password/reset') }}">Forgot Your Password?</a>
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
