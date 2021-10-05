@extends('layouts.master')
@section('account_limits')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
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
				<table class="stack hover">
					<thead>
						<tr>
							<th>Limit Type</th>
							<th>Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Daily Limit</td>
							<td>{{ $daily_limit ? $daily_limit->account_limit : 0 }}</td>
						</tr>
						<tr>
							<td>Monthly Limit</td>
							<td>{{ $monthly_limit ? $monthly_limit->account_limit : 0 }}</td>
						</tr>
						<tr>
							<td>Transaction Limit</td>
							<td>{{ $transaction_limit ? $transaction_limit->account_limit : 0 }}</td>
						</tr>
						<tr>
							<td>Weekly Limit</td>
							<td>{{ $weekly_limit ? $weekly_limit->account_limit : 0 }}</td>
						</tr>
					</tbody>
				</table>
				<a href="{{ route('account-limits-edit', $account_type_slug->account_type_slug) }}" title="Edit Account Limits" class="expanded button">Edit Account Limits</a>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			