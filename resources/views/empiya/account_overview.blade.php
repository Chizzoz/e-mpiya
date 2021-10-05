@extends('layouts.master')
@section('account_overview')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column account-overview-header my-callout">
				<h4>Your {{ $account_type_slug->account_type }} Details</h4>
			</div>
			<div class="large-12 medium-12 small-12 account-specific-account-info-links column">
				<ul class="menu">
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'detailed_balance')) }}" title="Detailed Balance">Detailed Balance</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'account_limits')) }}" title="Account Limits">Account Limits</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'transaction_history')) }}" title="Transaction History">Transaction History</a>
					</li>
					<li>
						<a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'statement_history')) }}" title="Statement History">Statement History</a>
					</li>
				</ul>
			</div>
				<div class="large-6 medium-6 small-12 column">
					<div class="large-12 medium-12 small-12 column my-callout">
						<h4><u>Account Balance</u></h4>
						<ul class="vertical menu">
							<li><strong>Available Balance:</strong> {{ $available_balance ? $available_balance->final_balance : 0 }}</li>
							<li><strong>Actual Balance:</strong></li>
							<li><strong>Pending Transactions:</strong> {{ $pending_transactions or 0 }}</li>
						</ul>
						<small class="account-overview-detailed-link"><a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'detailed_balance')) }}" title="Detailed Balance">More Details</a></small>
					</div>
				</div>
				<div class="large-6 medium-6 small-12 column">
					<div class="large-12 medium-12 small-12 column my-callout">
						<h4><u>Limits</u></h4>
						<ul class="vertical menu">
							@foreach ($account_limits as $account_limit)
							<li><strong>{{ $account_limit->account_limit_type }}:</strong> {{ $account_limit->account_limit }}</li>
							@endforeach
						</ul>
						<small class="account-overview-detailed-link"><a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'account_limits')) }}" title="Detailed Account Limits">More Details</a></small>
					</div>
				</div>
				<div class="large-12 medium-12 small-12 column">
					<div class="large-12 medium-12 small-12 column my-callout">
						<h4><u>Transaction History</u></h4>
						<?php
							$brief_transaction_histories_count = 1;
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
								@foreach ($brief_transaction_histories as $brief_transaction_history)
									<tr>
										<td>{{ $brief_transaction_histories_count }}</td>
										<td>{{ date_format(date_create($brief_transaction_history->created_at), "d/m/Y H:i:s") }}</td>
										<td>{{ $brief_transaction_history->reference_number }}</td>
										<td>{{ $brief_transaction_history->description }}</td>
										<td>{{ $brief_transaction_history->amount }}</td>
										<td>{{ $brief_transaction_history->initial_balance }}</td>
										<td>{{ $brief_transaction_history->final_balance }}</td>
									</tr>
									<?php $brief_transaction_histories_count++; ?>
								@endforeach
							</tbody>
						</table>
						<small class="account-overview-detailed-link"><a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'transaction_history')) }}" title="Transaction History">More Details</a></small>
					</div>
				</div>
				<div class="large-6 medium-6 small-12 column">
					<div class="large-12 medium-12 small-12 column my-callout">
						<h4><u>Statement History</u></h4>
						<p>D</p>
						<small class="account-overview-detailed-link"><a href="{{ route('specific-account-info', array($account_type_slug->account_type_slug, 'statement_history')) }}" title="Statement History">More Details</a></small>
					</div>
				</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			