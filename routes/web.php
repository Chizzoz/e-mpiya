<?php

use App\Models\Content;
use App\Models\EmpiyaAccount;
use App\Models\EmpiyaProvider;
use App\Models\EmpiyaTransactionType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	
	// get e-Mpiya transaction types
	$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
	// get e-Mpiya transaction providers
	$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
	
	if (Auth::check()) {
		$user = auth()->user(); //temp
		// get user empiya account types
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		$data['user'] = $user;
	}
	
	/* pass variables to view */
	$data['heading'] = "Welcome to e-Mpiya OMPS";
	
	return view('home', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);

// About
Route::get('/about', function(){
$data['heading'] = "About";
	
	return view('about', $data);
});
// Contact
Route::get('/contact', function(){
	$data['heading'] = "Contact Us";
	
	return view('contact', $data);
});
// Credits
Route::get('/credits', function(){
	$data['heading'] = "Credits";
	
	return view('credits', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
});
// Contact Submit
Route::post('/contact', function(Request $request) {
	$data['name'] = $request->name;
	$data['email'] = $request->email;
	$data['phone'] = $request->phone;
	$data['inquiry'] = $request->inquiry;
	
	/* pass variables to view */
	$data['link'] = "contact";
	
	return response()->view('contact', $data);
});
// Terms and Conditions
Route::get('/terms', function(){
	$data['heading'] = "Terms";
	
	return view('terms', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
});

// e-Mpiya routes
// user account related
Route::get('/account/{account_type_slug}', [App\Http\Controllers\EmpiyaController::class, 'accountOverview'])->name('account-overview');
Route::get('/account/{account_type_slug}/info', [App\Http\Controllers\EmpiyaController::class, 'selectSpecificAccountInfo'])->name('select-specific-account-info');
Route::get('/account/select/info/{specific_account_info_slug}', [App\Http\Controllers\EmpiyaController::class, 'selectAccountForSpecificInfo'])->name('select-account-for-specific-info');
Route::get('/account/{account_type_slug}/info/{specific_account_info_slug}', [App\Http\Controllers\EmpiyaController::class, 'specificAccountInfo'])->name('specific-account-info');
Route::get('/account/{account_type_slug}/info/account_limits/edit', [App\Http\Controllers\EmpiyaController::class, 'accountLimitsEdit'])->name('account-limits-edit');
// transaction related
Route::get('/transaction/select', [App\Http\Controllers\EmpiyaController::class, 'selectTransactionType'])->name('select-transaction-type');
Route::get('/transaction/{transaction_type_slug}/provider', [App\Http\Controllers\EmpiyaController::class, 'selectTransactionProvider'])->name('select-transaction-provider');
Route::get('/transaction/{transaction_type_slug}/provider/{provider_slug}', [App\Http\Controllers\EmpiyaController::class, 'newTransaction'])->name('new-transaction');
// confirm transaction
Route::get('/confirm/transaction/{transaction_type_slug}/provider/{provider_slug}', [App\Http\Controllers\EmpiyaController::class, 'newTransaction'])->name('confirm-new-transaction');
// Update Account Limits
Route::post('/account/{account_type_slug}/info/account_limits/update', [App\Http\Controllers\EmpiyaController::class, 'updateAccountLimits'])->name('update-account-limits');
// Confirm MTN Request Payment
Route::post('/confirm-request-payment/transaction/{transaction_type_slug}/provider/{provider_slug}', [App\Http\Controllers\MtnController::class, 'requestPaymentConfirm'])->name('post-confirm-mtn-request-payment');
// Confirm MTN Request Payment
Route::get('/confirm-request-payment/transaction/{transaction_type_slug}/provider/{provider_slug}/{user_empiya_account_type}/{mtn_money_number}/{deposit_amount}', [App\Http\Controllers\MtnController::class, 'requestPaymentConfirmGet'])->name('get-confirm-mtn-request-payment');
// Request MTN Payment
Route::post('/request-payment/transaction/{transaction_type_slug}/provider/{provider_slug}', [App\Http\Controllers\MtnController::class, 'requestPayment'])->name('post-mtn-request-payment');
// Complete New Transaction
Route::get('/complete/transaction/{transaction_type_slug}/provider/{provider_slug}/transaction/{transaction_id}', [App\Http\Controllers\EmpiyaController::class, 'completeNewTransaction'])->name('complete-new-transaction');
//Confirm Third Party Payment
Route::post('/mtn/ConfirmThirdPartyPayment', [App\Http\Controllers\MtnResponseController::class, 'confirmThirdPartyPayment'])->name('confirm-third-party-payment');
// Deposit Mobile Money
Route::post('/mtn/DepositMobileMoney', [App\Http\Controllers\MtnController::class, 'depositMobileMoney'])->name('post-mtn-deposit-mobile-money');
//Confirm Third Party Payment
Route::post('/mtn/QueryThirdPartyAccount', [App\Http\Controllers\MtnResponseController::class, 'queryThirdPartyAccount'])->name('query-third-party-account');
//request Payment Completed
Route::post('/mtn/requestPaymentCompleted', [App\Http\Controllers\MtnResponseController::class, 'requestPaymentCompleted'])->name('request-payment-completed');
// merchant purchase request
Route::post('/merchant/purchase/request', [App\Http\Controllers\MtnResponseController::class, 'merchantPurchaseRequest'])->name('merchant-purchase-request');
// merchant purchase confirm
Route::get('/merchant/purchase/confirm/{merchant_id}/{amount}/{empiya_account_number}/{item}/{transaction}', [App\Http\Controllers\MtnResponseController::class, 'merchantPurchaseConfirm'])->name('merchant-purchase-confirm');
// merchant purchase complete
Route::post('/merchant/purchase/complete', [App\Http\Controllers\MtnResponseController::class, 'merchantPurchaseComplete'])->name('merchant-purchase-complete');
// e-Mpiya money transfer
Route::post('/send/transaction/{transaction_type_slug}/provider/{provider_slug}', [App\Http\Controllers\EmpiyaController::class, 'empiyaMoneyTransfer'])->name('empiya-money-transfer');
// e-Mpiya money transfer confirm
Route::post('/money-transfer-confirm/transaction/{transaction_type_slug}/provider/{provider_slug}', [App\Http\Controllers\MtnController::class, 'moneyTransferConfirm'])->name('post-money-transfer-confirm');
// Confirm e-Mpiya money transfer
// Route::get('/money-transfer-confirm/transaction/{transaction_type_slug}/provider/{provider_slug}/{user_empiya_account_type}/{mtn_money_number}/{deposit_amount}', [App\Http\Controllers\MtnController::class, 'requestPaymentConfirmGet'])->name('get-confirm-mtn-request-payment');
// Request MTN Payment
Route::get('/api/sms/deposit/{mobile_number}/{deposit_amount}', [App\Http\Controllers\MtnResponseController::class, 'requestPaymentViaSms'])->name('mtn-deposit-via-sms');

// User routes
Route::get('/user/assigndefaults', [App\Http\Controllers\UserController::class, 'userAssignDefaults'])->name('user-assign-defaults');
Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'viewUserProfile'])->name('view-user-profile');
Route::get('/user/{user}/associates', [App\Http\Controllers\UserController::class, 'associatesList'])->name('associates-list');
Route::get('/user/{user}/checklist', [App\Http\Controllers\UserController::class, 'userChecklist'])->name('user-checklist');
Route::get('/user/{user}/edit', [App\Http\Controllers\UserController::class, 'editUserProfile'])->name('edit-user-profile');

// User relationship routes
Route::get('/user/{associated}/request_association/{associator}', [App\Http\Controllers\RelationshipController::class, 'requestAssociation'])->name('request-association');
Route::get('/user/{user}/delete_association_request/{user_relationship}', [App\Http\Controllers\RelationshipController::class, 'deleteAssociationRequest'])->name('delete-association-request');
Route::get('/user/{user}/cancel_delete_association_request/{user_relationship}', [App\Http\Controllers\RelationshipController::class, 'cancelDeleteAssociationRequest'])->name('cancel-delete-association-request');
Route::get('/user/{user}/accept_delete_association_request/{user_relationship}', [App\Http\Controllers\RelationshipController::class, 'acceptDeleteAssociationRequest'])->name('accept-delete-association-request');

Route::get('/user/{user}/accept_pending_association_request/{user_relationship}', [App\Http\Controllers\RelationshipController::class, 'acceptPendingAssociationRequest'])->name('accept-pending-association-request');
Route::get('/user/{user}/delete_pending_association_request/{user_relationship}', [App\Http\Controllers\RelationshipController::class, 'deletePendingAssociationRequest'])->name('delete-pending-association-request');

// User posts
Route::post('/user/{user}/update', [App\Http\Controllers\UserController::class, 'updateUserProfile'])->name('update-user-profile');

// Admin routes
// manage content
Route::get('/user/{user}/manage/{content_type}', [App\Http\Controllers\ManagementController::class, 'manageContent'])->name('manage-content');
Route::get('/user/{user}/publish/{content}', [App\Http\Controllers\ManagementController::class, 'publishContent'])->name('publish-content');
Route::get('/user/{user}/unpublish/{content}', [App\Http\Controllers\ManagementController::class, 'unpublishContent'])->name('unpublish-content');
Route::get('/user/{user}/approve/{content}', [App\Http\Controllers\ManagementController::class, 'approveContent'])->name('approve-content');
Route::get('/user/{user}/unapprove/{content}', [App\Http\Controllers\ManagementController::class, 'unapproveContent'])->name('unapprove-content');
// manage users
Route::get('/user/{user}/manage-users', [App\Http\Controllers\ManagementController::class, 'manageUsers'])->name('manage-users');
Route::get('/user/{user}/activate', [App\Http\Controllers\ManagementController::class, 'activateUser'])->name('activate-user');
Route::get('/user/{user}/deactivate', [App\Http\Controllers\ManagementController::class, 'deactivateUser'])->name('deactivate-user');

// Social Login Authentication
Route::get('/login/redirect/{provider}', [Auth\SocialAuthController::class, 'redirect'])->name('social-login');
Route::get('/login/callback/{provider}', [Auth\SocialAuthController::class, 'callback'])->name('callback');
