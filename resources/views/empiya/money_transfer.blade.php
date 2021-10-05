@extends('layouts.master')
@section('money_transfer')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column mtn-deposit-header my-callout">
				<h4>{{ $heading }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 mtn-deposit column">
				@if (Session::get('balance_error'))
					<span class="error">{{ Session::get('balance_error') }}</span>
				@endif
				@if (Session::get('account_error'))
					<span class="error">{{ Session::get('account_error') }}</span>
				@endif
				<form action="{{ route('post-money-transfer-confirm', array($transaction_type_slug->transaction_type_slug, $provider_slug->provider_slug)) }}" method="POST">
					{{ csrf_field() }}
					<!-- Select Account -->
					<div class="large-12 medium-12 small-12 columns">
						<label>From Account:</label>
						<select name="sender_empiya_account_type">
							@foreach($user_empiya_accounts as $user_empiya_account)
								<option value="{{$user_empiya_account->id}}">{{ $user_empiya_account->account_type }}</option>
							@endforeach
						</select>
						<span class="required">(Required) Account to Transfer Money From</span>
					</div>
					<!-- To e-Mpiya Account -->
					<div class="large-12 medium-12 small-12 columns">
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>To Account*</strong></span>
							</div>
							<div class="medium-9 column">
								<input id="receiver_empiya_account" type="text" name="receiver_empiya_account" placeholder="e-Mpiya Acc No. OR Receivers Name" value="{{ old('receiver_empiya_account') }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('receiver_empiya_account') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) 13-digit e-Mpiya Account Number or Receivers Name</span>
					</div>
					<!-- Amount To Deposit From MTN Money -->
					<div class="large-12 medium-12 small-12 columns">
						<div class="row collapse prefix-radius">
							<div class="medium-3 columns">
								<span class="prefix"><strong>Transfer Amount*</strong></span>
							</div>
							<div class="medium-9 column">
								<input type="text" name="transfer_amount" placeholder="Transfer Amount" value="{{ old('transfer_amount') }}" />
							</div>
						</div>
						@if (count($errors) > 0)
							@foreach ($errors->get('transfer_amount') as $error)
								<span class="error">{{ $error }}</span>
							@endforeach
						@endif
						<span class="required">(Required) Amount To Transfer</span>
					</div>
					<div class="expanded button-group">
						<input type="submit" value="Transfer" class="button" />
						<a href="{{ route('select-transaction-type') }}" class="button">Cancel</a>
					</div>
				</form>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			