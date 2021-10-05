@extends('layouts.master')
@section('mtn_confirm_deposit')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column mtn-deposit-header my-callout">
				<h4>{{ $heading }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 mtn-deposit column">
				@if (Session::get('server_error'))
					<span class="error">{{ Session::get('server_error') }}</span>
				@endif
				@if (Session::get('email_error'))
					<span class="error">{{ Session::get('server_error') }}</span>
				@endif
				<p>Are you sure you want to withdraw <strong>K{{ $deposit_amount }}</strong> from your <strong>MTN Money Account</strong> and Deposit into your <strong>e-Mpiya {{ $receiver_empiya_account_type->account_type }}</strong>?</p>
				<form action="{{ route('post-mtn-request-payment', array($transaction_type_slug->transaction_type_slug, $provider_slug->provider_slug)) }}" method="POST">
					{{ csrf_field() }}
					<!-- Select Account -->
					<div class="large-12 medium-12 small-12 columns">
						<label>Deposit To:</label>
						<select name="user_empiya_account">
							@foreach($user_empiya_accounts as $user_empiya_account)
								<option value="{{$user_empiya_account->id}}">{{ $user_empiya_account->account_type }}</option>
							@endforeach
						</select>
						@if (count($errors) > 0)
							@foreach ($errors->get('user_empiya_account') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) Select the account to deposit to</span>
					</div>
					<!-- From MTN Money Number -->
					<div class="large-12 medium-12 small-12 columns">
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>From MTN Money Number*</strong></span>
							</div>
							<div class="medium-9 column">
								<input readonly type="text" name="mtn_money_number" placeholder="MTN Money Number" value="{{ $mtn_money_number or old('mtn_money_number') }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('mtn_money_number') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) MTN Money Number To Deposit From, e.g: 096x xxx xxx</span>
					</div>
					<!-- Amount To Deposit From MTN Money -->
					<div class="large-12 medium-12 small-12 columns">
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>Amount*</strong></span>
							</div>
							<div class="medium-9 column">
								<input readonly type="text" name="deposit_amount" placeholder="Amount" value="{{ $deposit_amount }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('deposit_amount') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) Amount To Deposit From MTN Money</span>
					</div>
					<div class="expanded button-group">
						<input type="submit" value="Confirm" class="button" />
						<a href="{{ URL::previous() }}" class="button">Cancel</a>
					</div>
				</form>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			