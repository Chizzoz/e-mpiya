@extends('layouts.master')
@section('complete_money_transfer')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
				<h4>Money {{ $transaction_type_slug->transaction_type }} Into {{ $provider_slug->provider }} {{ $receiver_empiya_account_type->account_type }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<p>You have successfuly transferred <strong>K{{ $transaction_id->amount }}</strong> from your <strong>{{ $provider_slug->provider }} Account</strong> to <strong>{{ $recipient }}'s {{ $provider_slug->provider }} {{ $receiver_empiya_account_type->account_type }}</strong>. Transaction Reference number: <strong>{{ $transaction_id->reference_number }}</strong>.</p>
				<a href="{{ route('account-overview', $user_empiya_account_type->account_type_slug) }}" title="Continue" class="expanded button">Continue</a>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			