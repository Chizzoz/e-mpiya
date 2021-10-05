@extends('layouts.master')
@section('detailed_balance')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column detailed-balance-header my-callout">
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
							<th>Table Header</th>
							<th>Table Header</th>
							<th>Table Header</th>
							<th>Table Header</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer content Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
						<tr>
							<td>Content Goes Here</td>
							<td>This is longer Content Goes Here Donec id elit non mi porta gravida at eget metus.</td>
							<td>Content Goes Here</td>
							<td>Content Goes Here</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			