@extends('layouts.master')
@section('select_transaction_provider')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
				<h4>Select {{ $transaction_type_slug->transaction_type }} Transaction Provider</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				@if (Session::get('provider_error'))
					<span class="error">{{ Session::get('provider_error') }}</span>
				@endif
				<ul class="vertical menu">
					@foreach ($providers as $provider)
						<li>
							<a href="{{ route('new-transaction', array($transaction_type_slug->transaction_type_slug, $provider->provider_slug)) }}" title="{{ $provider->provider }}">{{ $provider->provider }}</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			