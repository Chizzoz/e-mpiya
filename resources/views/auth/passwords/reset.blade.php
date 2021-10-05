@extends('layouts.master')
@section('reset_password')
	<div class="large-12 medium-12 small-12 column reset">
		<div class="large-6 medium-6 small-12 column">
			<h2>Reset Password</h2>
			<div class="panel-body">
				<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
					{{ csrf_field() }}

					<input type="hidden" name="token" value="{{ $token }}">

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">E-Mail Address</label>

						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="{{ $email or old('email') }}">

							@if ($errors->has('email'))
								<span class="help-block">
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
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">Confirm Password</label>
						<div class="col-md-6">
							<input type="password" class="form-control" name="password_confirmation">

							@if ($errors->has('password_confirmation'))
								<span class="help-block">
									<strong>{{ $errors->first('password_confirmation') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="large expanded button">
								<i class="fa fa-btn fa-refresh"></i>Reset Password
							</button>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
@endsection
