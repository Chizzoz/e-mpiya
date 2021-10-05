@extends('layouts.master')
@section('confirm_purchase')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column mtn-deposit-header my-callout">
				<h4>{{ $heading }} {{ $user_empiya_account_type->account_type }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 mtn-deposit column">
				@if ($balance == 1)
					<p>Enter OTP sent to your email or mobile phone SMS to confirm buying <strong>{{ $item }}</strong> worth <strong>K{{ $amount }}</strong> using your <strong>e-Mpiya {{ $user_empiya_account_type->account_type }}</strong>?</p>
					<form action="{{ route('merchant-purchase-complete') }}" method="POST">
						{{ csrf_field() }}
						<input id="transaction_id" type="hidden" class="form-control" name="transaction_id" value="{{ $transaction_id }}" readonly>
						<input id="one_time_password_sent" type="hidden" class="form-control" name="one_time_password_sent" value="" readonly>
						<!-- Select Account -->
						<div class="large-12 medium-12 small-12 columns">
							<label>Buy Using:</label>
							<select name="user_empiya_account">
								@foreach($user_empiya_accounts as $user_empiya_account)
									<option value="{{$user_empiya_account->id}}">{{ $user_empiya_account->account_type }}</option>
								@endforeach
							</select>
							<span class="required">(Required) Account to Pay with</span>
						</div>
						<!-- Amount To Deposit From MTN Money -->
						<div class="large-12 medium-12 small-12 columns">
							<div class="row collapse prefix-radius">
								<div class="medium-3 columns">
									<span class="prefix"><strong>Amount*</strong></span>
								</div>
								<div class="medium-9 column">
									<input readonly type="text" name="amount" placeholder="Amount" value="{{ $amount }}" />
								</div>
							</div>
							<span class="required">(Required) Amount To Pay</span>
						</div>
						<!-- One Time Password (OTP) -->
						<div class="large-12 medium-12 small-12 columns">
							<div class="row collapse prefix-radius">
								<div class="medium-3 columns">
									<span class="prefix"><strong>One Time Password (OTP)*</strong></span>
								</div>
								<div class="medium-9 column">
									<input type="text" name="otp" placeholder="One Time Password (OTP)" <?php if ($balance == 0) echo 'readonly'; ?>/>
								</div>
							</div>
							@if (count($errors) > 0)
								@foreach ($errors->get('otp') as $error)
									<span class="error">{{ $error }}</span>
								@endforeach
							@endif
							<span class="required">(Required) 4-digit OTP sent to your email address and mobile number by sms</span>
						</div>
						<div class="expanded button-group">
							<input type="submit" value="Confirm" class="button" />
							<a href="http://localhost/zedstore.com/public/" class="button">Cancel</a>
						</div>
					</form>
				@else
					<p>You do not have enough money in your <strong>e-Mpiya {{ $user_empiya_account_type->account_type }}</strong> to buy <strong>{{ $item }}</strong> worth <strong>K{{ $amount }}</strong>. Please deposit some money into your account and try again.</p>
					<a href="http://localhost/zedstore.com/public/" title="Continue" class="expanded button">Continue</a>
				@endif
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			