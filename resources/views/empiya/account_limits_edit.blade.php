@extends('layouts.master')
@section('account_limits_edit')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
				<h4>{{ $heading }} for {{ $account_type_slug->account_type }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<form action="{{ route('update-account-limits', $account_type_slug->account_type_slug) }}" method="POST">
					{{ csrf_field() }}
					<input type="hidden" name="specific_account_info_slug" value="{{ Str::slug($specific_account_info_heading, "_") }}" />
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
								<td><input type="text" name="daily_limit" value="{{ $daily_limit ? $daily_limit->account_limit : 0 }}" /></td>
								@if (count($errors) > 0)
									@foreach ($errors->get('daily_limit') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
							</tr>
							<tr>
								<td>Monthly Limit</td>
								<td><input type="text" name="monthly_limit" value="{{ $monthly_limit ? $monthly_limit->account_limit : 0 }}" /></td>
								@if (count($errors) > 0)
									@foreach ($errors->get('monthly_limit') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
							</tr>
							<tr>
								<td>Transaction Limit</td>
								<td><input type="text" name="transaction_limit" value="{{ $transaction_limit ? $transaction_limit->account_limit : 0 }}" /></td>
								@if (count($errors) > 0)
									@foreach ($errors->get('transaction_limit') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
							</tr>
							<tr>
								<td>Weekly Limit</td>
								<td><input type="text" name="weekly_limit" value="{{ $weekly_limit ? $weekly_limit->account_limit : 0 }}" /></td>
								@if (count($errors) > 0)
									@foreach ($errors->get('weekly_limit') as $error)
										<span class="error">{{ $error }}</span>
									@endforeach
								@endif
							</tr>
						</tbody>
					</table>
					<div class="expanded button-group">
						<input type="submit" value="Save" class="button" />
						<a href="{{ url()->previous() }}" class="button">Cancel</a>
					</div>
				</form>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			