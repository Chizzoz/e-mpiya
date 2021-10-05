@section('right_sidebar')
	<div class="large-3 medium-3 small-12 columns right_sidebar">
		<div class="panel">
			@if (isset($transaction_types))
				<div class="large-12 medium-12 small-12 column artist my-callout">
					<h5>TRANSACTIONS</h5>
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
			@endif
			@if (isset($user_empiya_accounts))
				<div class="large-12 medium-12 small-12 column album my-callout">
					<h5>MY ACCOUNTS</h5>
					<ul class="vertical menu">
						@foreach ($user_empiya_accounts as $user_empiya_account)
							<li>
								<a href="{{ route('account-overview', $user_empiya_account->account_type_slug) }}" title="{{ $user_empiya_account->account_type }}">{{ $user_empiya_account->account_type }}</a>
							</li>
						@endforeach
					</ul>
				</div>
			@endif
			@if (isset($user))
				<div class="large-12 medium-12 small-12 column contributer my-callout">
					<h5>ACCOUNT INFO</h5>
					<ul class="vertical menu">
						<li>
							<a href="{{ route('select-account-for-specific-info', 'detailed_balance') }}" title="Detailed Balance">Detailed Balance</a>
						</li>
						<li>
							<a href="{{ route('select-account-for-specific-info', 'account_limits') }}" title="Account Limits">Account Limits</a>
						</li>
						<li>
							<a href="{{ route('select-account-for-specific-info', 'transaction_history') }}" title="Transaction History">Transaction History</a>
						</li>
						<li>
							<a href="{{ route('select-account-for-specific-info', 'statement_history') }}" title="Statement History">Statement History</a>
						</li>
					</ul>
				</div>
			@endif
		</div>
	</div>
@show