@extends('layouts.master')
@section('mtn_deposit')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column mtn-deposit-header my-callout">
				<h4>{{ $transaction_type_slug->transaction_type }} Using {{ $provider_slug->provider }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 mtn-deposit column">
				@if (Session::get('server_error'))
					<span class="error">{{ Session::get('server_error') }}</span>
				@endif
				<form action="{{ route('post-confirm-mtn-request-payment', array($transaction_type_slug->transaction_type_slug, $provider_slug->provider_slug)) }}" method="POST">
					{{ csrf_field() }}
					<!-- Select Account -->
					<div class="large-12 medium-12 small-12 columns">
						<label>Deposit To:</label>
						<select name="user_empiya_account_type">
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
								<input readonly type="text" name="mtn_money_number" placeholder="MTN Money Number" value="{{ $mtn_money_number ? $mtn_money_number->user_mobile_number : 0 }}" />
							</div>
							@if (!isset($mtn_money_number))
								<p>Please add your MTN Mobile Money number to your profile: <a href="{{ route('edit-user-profile', Auth::user()->username_slug) }}" title="Add MTN Number">Add MTN Number</a> </p>
							@endif
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
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			