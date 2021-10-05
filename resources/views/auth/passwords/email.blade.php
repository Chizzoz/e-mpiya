@extends('layouts.master')
@section('email_password')
	<div class="large-12 medium-12 small-12 column register">
		<div class="large-6 medium-6 small-12 column">
			<h2>Reset Password</h2>
			<div class="panel-body">
				@if (session('status'))
					<div class="alert alert-success">
						{{ session('status') }}
					</div>
				@endif

				<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
					{{ csrf_field() }}

					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						<label class="col-md-4 control-label">E-Mail Address</label>

						<div class="col-md-6">
							<input type="email" class="form-control" name="email" value="{{ old('email') }}">

							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-6 col-md-offset-4">
							<button type="submit" class="large expanded button">
								<i class="fa fa-btn fa-envelope"></i>Send Password Reset Link
							</button>
						</div>
					</div>
				</form>
			</div>
        </div>
    </div>
@endsection
