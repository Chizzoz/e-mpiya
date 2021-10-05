@extends('layouts.master')
@section('transaction_history')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column transaction-history-header my-callout">
				<h4>{{ $account_type_slug->account_type }} {{ $specific_account_info_heading }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 account-specific-account-info-links column">
				<ul class="menu">
					<li>
						<a href="{{ route('account-overview', $account_type_slug->account_type_slug) }}" title="{{ $account_type_slug->account_type }} Overview">Account Overview</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'detailed_balance')) }}" title="Detailed Balance">Detailed Balance</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'transaction_history')) }}" title="Transaction History">Transaction History</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'account_limits')) }}" title="Account Limits">Account Limits</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'statement_history')) }}" title="Statement History">Statement History</a>
					</li>
				</ul>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<?php
					$account_transaction_histories_count = ($account_transaction_histories->currentPage() - 1)*$account_transaction_histories->perPage();
				?>
				<table class="stack hover">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Ref. No.</th>
							<th>Description</th>
							<th>Amount (K)</th>
							<th>Initial Balance (K)</th>
							<th>Final Balance (K)</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($account_transaction_histories as $account_transaction_history)
							<tr>
								<td>{{ ++$account_transaction_histories_count }}</td>
								<td>{{ date_format(date_create($account_transaction_history->created_at), "d/m/Y H:i:s") }}</td>
								<td>{{ $account_transaction_history->reference_number }}</td>
								<td>{{ $account_transaction_history->description }}</td>
								<td>{{ $account_transaction_history->amount }}</td>
								<td>{{ $account_transaction_history->initial_balance }}</td>
								<td>{{ $account_transaction_history->final_balance }}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class='large-12 medium-12 small-12 column footer-top'>
				<center>
				@if (isset($account_transaction_histories))
					{!! $account_transaction_histories->render() !!}
				@endif
				</center>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			