@extends('layouts.master')
@section('view_transactions')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents my-callout">
			<div class="large-12 medium-12 small-12 column select-provider-header">
				<?php //<h4>{{ $transaction_type_slug->transaction_type }} Using {{ $transaction_provider_slug->transaction_provider }}</h4> ?>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<?php
					foreach ($response_xml->xpath('//return') as $return) {
						echo "//" . $return->name . " " . $return->value;
					}
				?>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			