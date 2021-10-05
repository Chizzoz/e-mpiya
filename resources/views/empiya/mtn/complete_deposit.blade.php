@extends('layouts.master')
@section('complete_deposit')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
				<h4>{{ $transaction_type_slug->transaction_type }} Into {{ $receiver_empiya_account_type->account_type }} From {{ $provider_slug->provider }} Confirmation</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<p>You have successfuly withdrawn <strong>K{{ $transaction_id->amount }}</strong> from your <strong>MTN Money Account</strong> and Deposited into your <strong>e-Mpiya {{ $receiver_empiya_account_type->account_type }}</strong>. Transaction Reference number: <strong>{{ $transaction_id->reference_number }}</strong>.</p>
				<a href="{{ route('account-overview', $receiver_empiya_account_type->account_type_slug) }}" title="Continue" class="expanded button">Continue</a>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			