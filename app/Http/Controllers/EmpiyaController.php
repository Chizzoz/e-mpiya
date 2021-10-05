<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\AccessPlatform;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\CreativesContent;
use App\Models\EmpiyaAccount;
use App\Models\EmpiyaAccountLimit;
use App\Models\EmpiyaAccountType;
use App\Models\EmpiyaProvider;
use App\Models\EmpiyaTransaction;
use App\Models\EmpiyaTransactionHistory;
use App\Models\EmpiyaTransactionType;
use App\Models\FactsContent;
use App\Models\UserMobile;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Image;

class EmpiyaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // index/ homepage
	public function index()
    {
        return view('layouts.content');
    }

    // user account overview
	public function accountOverview(EmpiyaAccountType $account_type_slug)
    {
		// get authenticated user
		$user = auth()->user();
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// get authenticated user
		$data['user'] = $user;
		$data['heading'] = "Account Overview";
		
		// Overview summary
		$user_account = EmpiyaAccount::whereUserId($user->id)->where('empiya_account_type_id', $account_type_slug->id)->get()->first();
		// detailed balance
		$data['available_balance'] = EmpiyaTransactionHistory::where('empiya_account_id', $user_account->id)->orderBy('created_at', 'DESC')->get()->first();
		$data['actual_balance'] = "";
		$data['pending_transactions'] = EmpiyaTransaction::where('sender_account_id', $user_account->id)->where('empiya_transaction_status_id', 1)->get()->count();
		// Account limits
		$data['account_limits'] = EmpiyaAccountLimit::where('empiya_account_id', $user_account->id)->join('empiya_account_limit_types', 'empiya_account_limits.empiya_account_limit_type_id', '=', 'empiya_account_limit_types.id')->get();
		// transaction history
		$data['brief_transaction_histories'] = EmpiyaTransactionHistory::where('empiya_account_id', $user_account->id)->join('empiya_transactions', 'empiya_transaction_histories.empiya_transaction_id', '=', 'empiya_transactions.id')->join('empiya_providers', 'empiya_transactions.empiya_provider_id', '=', 'empiya_providers.id')->orderBy('empiya_transaction_histories.created_at', 'DESC')->select('empiya_transaction_histories.*', 'empiya_transactions.reference_number AS reference_number', 'empiya_transactions.description AS description', 'empiya_transactions.amount AS amount', 'empiya_providers.provider AS provider')->take(5)->get();
		// Statement history
		
		// account type
		$data['account_type_slug'] = $account_type_slug;
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
        return view('empiya.account_overview', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
    }

    // select account for specific information
	public function selectAccountForSpecificInfo($specific_account_info_slug)
    {
		// get authenticated user
		$user = auth()->user();
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// get authenticated user
		$data['user'] = $user;
		$data['heading'] = "Select Account For " . Str::replace("_", " ", Str::title($specific_account_info_slug));
		
		// specific account info text
		$data['specific_account_info_slug'] = $specific_account_info_slug;
		// get user empiya account
		$user_empiya_accounts = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		$data['user_empiya_accounts'] = $user_empiya_accounts;
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// automatically redirect if only one account
		$number_of_user_empiya_accounts = User::find($user->id)->empiyaAccounts()->count();
		if ($number_of_user_empiya_accounts < 2) {
			return redirect()->route('specific-account-info', array($user_empiya_accounts->first()->account_type_slug, $specific_account_info_slug));
		}
		
        return view('empiya.select_account_for_specific_info', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
    }

    // user specific account information
	public function specificAccountInfo(EmpiyaAccountType $account_type_slug, $specific_account_info_slug)
    {
		// get authenticated user
		$user = auth()->user();
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// get authenticated user
		$data['user'] = $user;
		$data['heading'] = "Select Account Information";
		
		// account type
		$data['account_type_slug'] = $account_type_slug;
		// specific account info heading
		$data['specific_account_info_heading'] = Str::replace("_", " ", Str::title($specific_account_info_slug));
		// get user empiya accounts
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		// get user account based on account type
		$user_empiya_account = EmpiyaAccount::whereUserId($user->id)->where('empiya_account_type_id', $account_type_slug->id)->get()->first();
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// detailed balance view
		if ($specific_account_info_slug == 'detailed_balance') {
			return view('empiya.detailed_balance', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
		}
		// account limits view
		elseif ($specific_account_info_slug == 'account_limits') {
			$data['daily_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 1)->first();
			$data['monthly_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 2)->first();
			$data['transaction_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 3)->first();
			$data['weekly_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 4)->first();
			
			return view('empiya.account_limits', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
		}
		// transaction history view
		elseif ($specific_account_info_slug == 'transaction_history') {
			// transaction history
			$account_transaction_histories = EmpiyaTransactionHistory::where('empiya_account_id', $user_empiya_account->id)->join('empiya_transactions', 'empiya_transaction_histories.empiya_transaction_id', '=', 'empiya_transactions.id')->join('empiya_providers', 'empiya_transactions.empiya_provider_id', '=', 'empiya_providers.id')->orderBy('empiya_transaction_histories.created_at', 'DESC')->select('empiya_transaction_histories.*', 'empiya_transactions.reference_number AS reference_number', 'empiya_transactions.description AS description', 'empiya_transactions.amount AS amount', 'empiya_providers.provider AS provider');
			//$data['account_transaction_histories_count'] = count($account_transaction_histories->get());
			$data['account_transaction_histories'] = $account_transaction_histories->paginate(10);
			
			return view('empiya.transaction_history', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
		}
		// statement history view
		elseif ($specific_account_info_slug == 'statement_history') {
			return view('empiya.statement_history', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
		}
		// invalid entry
		else {
			return redirect('/');
		}
    }

    // user specific account information
	public function accountLimitsEdit(EmpiyaAccountType $account_type_slug)
    {
		// get authenticated user
		$user = auth()->user();
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// get authenticated user
		$data['user'] = $user;
		$data['heading'] = "Edit Account Limits";
		
		// account type
		$data['account_type_slug'] = $account_type_slug;
		// specific account info heading
		$data['specific_account_info_heading'] = Str::replace("_", " ", Str::title("account_limits"));
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		// get user account based on account type
		$user_empiya_account = EmpiyaAccount::whereUserId($user->id)->where('empiya_account_type_id', $account_type_slug->id)->get()->first();
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		$data['daily_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 1)->first();
		$data['monthly_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 2)->first();
		$data['transaction_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 3)->first();
		$data['weekly_limit'] = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->id)->where('empiya_account_limit_type_id', 4)->first();
		
		return view('empiya.account_limits_edit', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
    }
	
	// update account limits
	public function updateAccountLimits(EmpiyaAccountType $account_type_slug, Request $request)
	{
		$this->validate($request, [
			'daily_limit' => 'numeric|min:0|gt:transaction_limit',
			'monthly_limit' => 'numeric|min:0|gt:transaction_limit|gt:daily_limit|gt:weekly_limit',
			'transaction_limit' => 'required|numeric|min:0',
			'weekly_limit' => 'numeric|min:0|gt:transaction_limit|gt:daily_limit',
		]);
		
		// get authenticated user
		$user = auth()->user();
		// user empiya account
		$user_empiya_account = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->where('account_type_slug', $account_type_slug->account_type_slug)->select('empiya_accounts.id AS empiya_account_id', 'empiya_account_types.account_type_slug AS account_type_slug')->first();
		// user daily limit
		$user_daily_limit = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->empiya_account_id)->where('empiya_account_limit_type_id', 1)->first();
		// set daily limit
		if (isset($user_daily_limit) && $request->daily_limit >= 0) {
			$daily_limit = EmpiyaAccountLimit::where('empiya_account_id', $user_daily_limit->empiya_account_id)->where('empiya_account_limit_type_id', $user_daily_limit->empiya_account_limit_type_id)->first();
			$daily_limit->account_limit = $request->daily_limit;
			$daily_limit->save();
		} elseif ($request->daily_limit >= 0) {
			$daily_limit = new EmpiyaAccountLimit;
			$daily_limit->empiya_account_id = $user_empiya_account->empiya_account_id;
			$daily_limit->empiya_account_limit_type_id = 1;
			$daily_limit->account_limit = $request->daily_limit;
			$daily_limit->save();
		}
		// user monthly limit
		$user_monthly_limit = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->empiya_account_id)->where('empiya_account_limit_type_id', 2)->first();
		// set monthly limit
		if (isset($user_monthly_limit) && $request->monthly_limit >= 0) {
			$monthly_limit = EmpiyaAccountLimit::where('empiya_account_id', $user_monthly_limit->empiya_account_id)->where('empiya_account_limit_type_id', $user_monthly_limit->empiya_account_limit_type_id)->first();
			$monthly_limit->account_limit = $request->monthly_limit;
			$monthly_limit->save();
		} elseif ($request->monthly_limit >= 0) {
			$monthly_limit = new EmpiyaAccountLimit;
			$monthly_limit->empiya_account_id = $user_empiya_account->empiya_account_id;
			$monthly_limit->empiya_account_limit_type_id = 2;
			$monthly_limit->account_limit = $request->monthly_limit;
			$monthly_limit->save();
		}
		// user transaction limit
		$user_transaction_limit = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->empiya_account_id)->where('empiya_account_limit_type_id', 3)->first();
		// set transaction limit
		if (isset($user_transaction_limit) && $request->transaction_limit >= 0) {
			$transaction_limit = EmpiyaAccountLimit::where('empiya_account_id', $user_transaction_limit->empiya_account_id)->where('empiya_account_limit_type_id', $user_transaction_limit->empiya_account_limit_type_id)->first();
			$transaction_limit->account_limit = $request->transaction_limit;
			$transaction_limit->save();
		} elseif ($request->transaction_limit >= 0) {
			$transaction_limit = new EmpiyaAccountLimit;
			$transaction_limit->empiya_account_id = $user_empiya_account->empiya_account_id;
			$transaction_limit->empiya_account_limit_type_id = 3;
			$transaction_limit->account_limit = $request->transaction_limit;
			$transaction_limit->save();
		}
		// user weekly limit
		$user_weekly_limit = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->where('empiya_account_id', $user_empiya_account->empiya_account_id)->where('empiya_account_limit_type_id', 4)->first();
		// set weekly limit
		if (isset($user_weekly_limit) && $request->weekly_limit >= 0) {
			$weekly_limit = EmpiyaAccountLimit::where('empiya_account_id', $user_weekly_limit->empiya_account_id)->where('empiya_account_limit_type_id', $user_weekly_limit->empiya_account_limit_type_id)->first();
			$weekly_limit->account_limit = $request->weekly_limit;
			$weekly_limit->save();
		} elseif ($request->weekly_limit >= 0) {
			$weekly_limit = new EmpiyaAccountLimit;
			$weekly_limit->empiya_account_id = $user_empiya_account->empiya_account_id;
			$weekly_limit->empiya_account_limit_type_id = 4;
			$weekly_limit->account_limit = $request->weekly_limit;
			$weekly_limit->save();
		}
		
		// account type
		$account_type_slug = $account_type_slug->account_type_slug;
		// specific account info slug
		$specific_account_info_slug = $request->specific_account_info_slug;
		
		return redirect()->route('specific-account-info', array($account_type_slug, $specific_account_info_slug));
	}

    // new e-Mpiya transaction
	public function selectTransactionType()
    {
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// get authenticated user
		$user = auth()->user();
		$data['user'] = $user;
		$data['heading'] = "Select New Transaction";
		
		// get user empiya account types
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
        return view('empiya.select_transaction_type', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
    }

    // get transaction providers
	public function selectTransactionProvider(EmpiyaTransactionType $transaction_type_slug)
    {
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(1);
		// get authenticated user
		$user = auth()->user();
		$data['user'] = $user;
		$data['heading'] = "Select Transaction Provider";
		
		// transaction type slug
		$data['transaction_type_slug'] = $transaction_type_slug;
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// get user empiya account types
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
        return view('empiya.select_transaction_provider', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
    }

    // create new transaction form
	public function newTransaction(EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug)
    {
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(1);
		// get authenticated user
		$user = auth()->user();
		$data['user'] = $user;
		$data['heading'] = "Transfer Money to Another e-Mpiya Account";
		
		// transaction type slug
		$data['transaction_type_slug'] = $transaction_type_slug;
		
		// provider model
		$data['provider_slug'] = $provider_slug;
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		// user e-Mpiya account type
		//$data['user_empiya_account_type'] = EmpiyaAccountType::whereId($user_empiya_account->empiya_account_type_id)->get()->first();
		
		// MTN Transactions
		if ($provider_slug->id == 2) {
			$data['mtn_money_number'] = UserMobile::whereUserId($user->id)->where('mobile_service_provider_id', $provider_slug->id)->get()->first();
			// deposit
			if ($transaction_type_slug->id == 1) {
				return view('empiya.mtn.deposit', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
			// purchase
			elseif ($transaction_type_slug->id == 2) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// transfer
			elseif ($transaction_type_slug->id == 3) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// withdraw
			elseif ($transaction_type_slug->id == 4) {
				return view('empiya.new_transaction', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
		}
		
		// e-Mpiya Transactions
		if ($provider_slug->id == 5) {
			// deposit
			if ($transaction_type_slug->id == 1) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// purchase
			elseif ($transaction_type_slug->id == 2) {
				return view('empiya.new_transaction', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
			// transfer
			elseif ($transaction_type_slug->id == 3) {
				$user_account_numbers = EmpiyaAccount::all()->pluck('account_number');
				$usernames = EmpiyaAccount::distinct()->join('users', 'empiya_accounts.user_id', '=', 'users.id')->pluck('username');
				$data['usernames_and_account_numbers'] = $user_account_numbers->merge($usernames)->toJson();
				
				return view('empiya.money_transfer', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
			// withdraw
			elseif ($transaction_type_slug->id == 4) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
		}
		
        return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
    }
	
	// Complete new transaction
	public function completeNewTransaction (EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug, EmpiyaTransaction $transaction_id)
	{
		// logged in user
		$user = auth()->user();
		
		// sender e-Mpiya account
		$sender_empiya_account = EmpiyaAccount::whereId($transaction_id->sender_account_id)->get()->first();
		$data['sender_empiya_account_type'] = EmpiyaAccountType::whereId($sender_empiya_account->empiya_account_type_id)->get()->first();
		$data['sender'] = User::whereId($sender_empiya_account->user_id)->get()->first();
		
		// receiver e-Mpiya account
		$receiver_empiya_account = EmpiyaAccount::whereId($transaction_id->receiver_account_id)->get()->first();
		$data['receiver_empiya_account_type'] = EmpiyaAccountType::whereId($receiver_empiya_account->empiya_account_type_id)->get()->first();
		$data['recipient'] = User::whereId($receiver_empiya_account->user_id)->get()->first();
		
		// transaction type slug
		$data['transaction_type_slug'] = $transaction_type_slug;
		
		// provider model
		$data['provider_slug'] = $provider_slug;
		
		// transaction
		$data['transaction_id'] = $transaction_id;
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		// MTN completed transaction
		if ($provider_slug->id == 2) {
			// deposit
			if ($transaction_type_slug->id == 1) {
				return view('empiya.mtn.complete_deposit', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
			// purchase
			elseif ($transaction_type_slug->id == 2) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// transfer
			elseif ($transaction_type_slug->id == 3) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// withdraw
			elseif ($transaction_type_slug->id == 4) {
				return view('empiya.new_transaction', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
		}
		// e-Mpiya completed transaction
		if ($provider_slug->id == 5) {
			// deposit
			if ($transaction_type_slug->id == 1) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// purchase
			elseif ($transaction_type_slug->id == 2) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
			// transfer
			elseif ($transaction_type_slug->id == 3) {
				return view('empiya.complete_money_transfer', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
			}
			// withdraw
			elseif ($transaction_type_slug->id == 4) {
				return redirect()->route('select-transaction-provider', $transaction_type_slug->transaction_type_slug)->with('provider_error', 'Provider Not Yet Supported');
			}
		}
	}
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function moneyTransferConfirm(EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug, Request $request)
	{
		$input = Input::only('receiver_empiya_account'); // dont use all(), ever
		$rules = [
			'receiver_empiya_account' => 'required'
		];
		if (strlen($input['receiver_empiya_account']) == 13 && (substr($input['receiver_empiya_account'], -1) == 1))
		{
			$rules['receiver_empiya_account'] .= '|exists:empiya_accounts,account_number';
		}
		else
		{
			$rules['receiver_empiya_account'] .= '|exists:users,username';
		}

		$validator = Validator::make($input, $rules);
		
		$this->validate($request, [
			'sender_empiya_account_type' => 'required|numeric',
			'transfer_amount' => 'required|numeric',
		]);
		
		$sender_empiya_account_type = $request->sender_empiya_account_type;
		$receiver_empiya_account = $request->receiver_empiya_account;
		$transfer_amount = $request->transfer_amount;
		
		return redirect()->route('get-confirm-mtn-request-payment', array($transaction_type_slug, $provider_slug, $sender_empiya_account_type, $receiver_empiya_account, $transfer_amount));
	}
	/**
	*	transfer money to another e-Mpiya Account
	**/
	public function moneyTransferComplete(EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug, Request $request)
	{
		$input = Input::only('receiver_empiya_account'); // dont use all(), ever
		$rules = [
			'receiver_empiya_account' => 'required'
		];
		if (strlen($input['receiver_empiya_account']) == 13 && (substr($input['receiver_empiya_account'], -1) == 1))
		{
			$rules['receiver_empiya_account'] .= '|exists:empiya_accounts,account_number';
		}
		else
		{
			$rules['receiver_empiya_account'] .= '|exists:users,username';
		}

		$validator = Validator::make($input, $rules);
		
		$this->validate($request, [
			'sender_empiya_account_type' => 'required|numeric',
			'transfer_amount' => 'required|numeric',
		]);
		// authenticated user details
		$user = auth()->user();
		$sender_account = EmpiyaAccount::whereUserId($user->id)->where('empiya_account_type_id', $request->sender_empiya_account_type)->get()->first();
		
		// check balance
		$user_recent_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $sender_account->id)->orderBy('created_at', 'DESC')->get()->first();
		if ($user_recent_transaction_history->final_balance < $request->transfer_amount) {
			return redirect()->back()->withInput()->with('balance_error', 'You do not have enough money to make this transfer. Please enter an amount within your balance or deposit money into your account.');
		}
		
		// store transaction
		$transaction = new EmpiyaTransaction;
		$transaction->empiya_provider_id = $provider_slug->id;
		// generate transaction reference number
		$merchant = "OMP";
		$date = date("dmy");
		$time = date("His");
		$now = date("Y-m-d H:i:s");
		$sequence = EmpiyaTransaction::where('created_at', $now)->count() + 1;
		$currency = "01";
		$transaction->reference_number = $merchant . strtoupper(dechex($date)) . strtoupper(dechex($time)) . strtoupper(dechex($sequence)) . strtoupper(dechex($currency));
		// sender
		//$transaction->sender_id = 1;
		$transaction->sender_account_id = $sender_account->id;
		// receiver
		//$transaction->receiver_id = $user->id;
		if (strlen($request->receiver_empiya_account) == 13 && (substr($request->receiver_empiya_account, -1) == 1)) {
			$receiver_account = EmpiyaAccount::where('account_number', $request->receiver_empiya_account)->get()->first();
			if ($sender_account->account_number == $request->receiver_empiya_account) {
				return redirect()->back()->withInput()->with('account_error', 'Sender and receiver cannot be the same account.');
			} else {
				$transaction->receiver_account_id = $receiver_account->id;
			}
		} else {
			$receiver = User::where('username', $request->receiver_empiya_account)->get()->first();
			$receiver_account = EmpiyaAccount::whereUserId($receiver->id)->get()->first();
			if ($user->username == $request->receiver_empiya_account) {
				return redirect()->back()->withInput()->with('account_error', 'Sender and receiver cannot be the same account.');
			} else {
				$transaction->receiver_account_id = $receiver_account->id;
			}
			
		}
		$transaction->amount = $request->transfer_amount;
		$transaction->transaction_fee = 0.00;
		$transaction->empiya_transaction_type_id = $transaction_type_slug->id;
		// e-Mpiya account type
		$user_account_type = EmpiyaAccountType::whereId($receiver_account->empiya_account_type_id)->get()->first();
		$transaction->description = "Transfer of money from " . $user->username . ": " . $sender_account->account_number . " to " . $receiver->username . "'s e-Mpiya " . $user_account_type->account_type . ": " . $receiver_account->account_number;
		// raw description
		$raw_description = "//" . $user->username . "//" . $sender_account->account_number . "//" . $provider_slug->provider_slug . "//" . $transaction_type_slug->transaction_type_slug . "//" . $receiver->username . "//" . $user_account_type->account_type . "//" . $receiver_account->account_number;
		$transaction->raw_description = $raw_description;
		
		// generate OTP
		$digits = 4;
		$otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
		$transaction->otp = $otp;
		
		$transaction->empiya_transaction_status_id = 3;
		$transaction->save();
		
		// create transaction history for sender
		$last_sender_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $transaction->sender_account_id)->orderBy('created_at', 'DESC')->get()->first();
		$sender_transaction_history = new EmpiyaTransactionHistory;
		$sender_transaction_history->empiya_transaction_id = $transaction->id;
		$sender_transaction_history->empiya_account_id = $transaction->sender_account_id;
		$sender_transaction_history->is_debit = 1;
		// get initial balance
		if (isset($last_sender_transaction_history)) {
			$sender_transaction_history->initial_balance = $last_sender_transaction_history->final_balance;
		} else {
			$sender_transaction_history->initial_balance = 0.00;
		}
		// calculate final balance of credited user
		if ($sender_transaction_history->is_debit == 0) {
			$sender_transaction_history->final_balance = $sender_transaction_history->initial_balance + $transaction->amount; // not debit (credit): add
		} else {
			$sender_transaction_history->final_balance = $sender_transaction_history->initial_balance - $transaction->amount; // debit: minus
		}
		$sender_transaction_history->save();
		// create transaction history for recipient
		$last_receiver_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $transaction->receiver_account_id)->orderBy('created_at', 'DESC')->get()->first();
		$transaction_history = new EmpiyaTransactionHistory;
		$transaction_history->empiya_transaction_id = $transaction->id;
		$transaction_history->empiya_account_id = $transaction->receiver_account_id;
		$transaction_history->is_debit = 0;
		// get initial balance
		if (isset($last_receiver_transaction_history)) {
			$transaction_history->initial_balance = $last_receiver_transaction_history->final_balance;
		} else {
			$transaction_history->initial_balance = 0.00;
		}
		// calculate final balance of credited user
		if ($transaction_history->is_debit == 0) {
			$transaction_history->final_balance = $transaction_history->initial_balance + $transaction->amount; // not debit (credit): add
		} else {
			$transaction_history->final_balance = $transaction_history->initial_balance - $transaction->amount; // debit: subtract
		}
		$transaction_history->save();
		
		// Send email
		try {
			if (!is_null($user->email)) {
				Mail::send('emails.otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
					$message->from('info@oneziko.com', 'One Ziko Info');
					$message->to($user->email, $user->username)->subject('Confirm Purchase Using Your e-Mpiya Account');
				});
				$message_sending_status = 1;
			}
		} catch (\Exception $e) {
			$message_sending_status = 0;
		}
		
		return redirect()->route('complete-new-transaction', array($transaction_type_slug, $provider_slug, $transaction->id));
	}
}
