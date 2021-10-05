@extends('layouts.master')
@section('select_account_for_specific_info')
	<div class="large-12 medium-12 small-12 column">
		<div class="large-9 medium-9 small-12 column contents">
			<div class="large-12 medium-12 small-12 column select-provider-header my-callout">
				<h4>Select Account to get {{ Str::replace("_", " ", Str::title($specific_account_info_slug)) }}</h4>
			</div>
			<div class="large-12 medium-12 small-12 transaction-providers-list column">
				<ul class="vertical menu">
					@foreach ($user_empiya_accounts as $user_empiya_account)
						<li>
							<a href="{{ route('specific-account-info', array($user_empiya_account->account_type_slug, $specific_account_info_slug)) }}" title="{{ $user_empiya_account->account_type }}">{{ $user_empiya_account->account_type }}</a>
						</li>
					@endforeach
				</ul>
			</div>
		</div>
		@yield('left_sidebar')
		@yield('right_sidebar')
	</div>
@stop


			