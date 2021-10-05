@extends('layouts.master')
@section('new_transaction')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column new-transaction-header my-callout">
				<h4>{{ $transaction_type_slug->transaction_type }} Using {{ $provider_slug->provider }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 new-transaction column">
				@if (Session::get('server_error'))
					<span class="error">{{ Session::get('server_error') }}</span>
				@endif
				@if ($transaction_type_slug->transaction_type == "Deposit" && $provider_slug->provider == "MTN")
				<form action="{{ route('post-mtn-request-payment') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="$transaction_type_slug" value="{{ $transaction_type_slug }}" />
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
								<input type="text" name="mtn_money_number" placeholder="MTN Money Number" value="{{ old('mtn_money_number') }}" />
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
								<input type="text" name="deposit_amount" placeholder="Amount" value="{{ old('deposit_amount') }}" />
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
						<input type="submit" value="Deposit" class="button" />
						<a href="{{ route('select-transaction-type') }}" class="button">Cancel</a>
					</div>
				</form>
				@else ($transaction_type_slug->transaction_type == "Withdraw" && $provider_slug->provider == "MTN)
				<form action="{{ route('post-mtn-deposit-mobile-money') }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="$transaction_type_slug" value="{{ $transaction_type_slug }}" />
					<!-- Select Account -->
					<div class="large-12 medium-12 small-12 columns">
						<label>Withdraw From:</label>
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
						<span class="required">(Required) Select the account to withraw from</span>
					</div>
					<!-- From MTN Money Number -->
					<div class="large-12 medium-12 small-12 columns">
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>To MTN Money Number*</strong></span>
							</div>
							<div class="medium-9 column">
								<input type="text" name="mtn_money_number" placeholder="MTN Money Number" value="{{ old('mtn_money_number') }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('mtn_money_number') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) MTN Money Number To Deposit To, e.g: 096x xxx xxx</span>
					</div>
					<!-- Amount To Withdraw From e-Mpiya -->
					<div class="large-12 medium-12 small-12 columns">
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>Amount*</strong></span>
							</div>
							<div class="medium-9 column">
								<input type="text" name="withdraw_amount" placeholder="Amount" value="{{ old('withdraw_amount') }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('withdraw_amount') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) Amount To Withdraw From e-Mpiya Account</span>
					</div>
					<div class="expanded button-group">
						<input type="submit" value="Withdraw" class="button" />
						<a href="{{ route('select-transaction-type') }}" class="button">Cancel</a>
					</div>
				</form>
				@endif
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			