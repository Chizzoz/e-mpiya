@extends('layouts.master')
@section('select_transaction_type')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-transaction-header my-callout">
				<h4>Select Transaction Type</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<ul class="vertical menu">
					@foreach ($transaction_types as $transaction_type)
						@if ($transaction_type->id == 3)
							@foreach ($providers as $provider)
								@if ($provider->id == 5)
									<li>
										<a href="{{ route('new-transaction', array($transaction_type->transaction_type_slug, $provider->provider_slug)) }}" title="{{ $transaction_type->transaction_type }}">{{ $transaction_type->transaction_type }}</a>
									</li>
								@endif
							@endforeach
						@else
							<li>
								<a href="{{ route('select-transaction-provider', $transaction_type->transaction_type_slug) }}" title="{{ $transaction_type->transaction_type }}">{{ $transaction_type->transaction_type }}</a>
							</li>
						@endif
					@endforeach
				</ul>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			