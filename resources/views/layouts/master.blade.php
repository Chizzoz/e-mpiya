@include('layouts.header')
	
	@yield('main')
	
	@yield('login')
	@yield('register')
	@yield('email_password')
	@yield('reset_password')
	
	@yield('user_profile_card')
	@yield('user_profile_view')
	@yield('user_profile_edit')
	
	@yield('user_associates')
	@yield('user_profile_preferences')
	@yield('user_checklist')
	
	@yield('home')
	@yield('manage_content')
	@yield('manage_users')
	
	@yield('account_overview')
	@yield('select_account_for_specific_info')
	@yield('detailed_balance')
	@yield('account_limits')
	@yield('account_limits_edit')
	@yield('transaction_history')
	@yield('statement_history')
	
	@yield('select_transaction_type')
	@yield('select_transaction_provider')
	@yield('mtn_deposit')
	@yield('mtn_confirm_deposit')
	@yield('confirm_purchase')
	@yield('complete_deposit')
	@yield('money_transfer')
	@yield('complete_money_transfer')
	@yield('view_transactions')
	@yield('view_transaction_details')
	
	@yield('about')
	@yield('contact')
	@yield('credits')
	@yield('terms')
	
@include('layouts.footer')