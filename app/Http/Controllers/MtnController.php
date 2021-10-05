<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\AccessPlatform;
use App\Models\ContentType;
use App\Models\EmpiyaAccount;
use App\Models\EmpiyaProvider;
use App\Models\EmpiyaTransaction;
use App\Models\EmpiyaTransactionHistory;
use App\Models\EmpiyaTransactionType;
use App\Models\User;
use Redirect;
use Session;
use SimpleXMLElement;

class MtnController extends Controller
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
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function requestPaymentConfirm(EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug, Request $request)
	{
		$this->validate($request, [
			'user_empiya_account_type' => 'required',
			'mtn_money_number' => 'required|regex:(^096\d{7}$)',
			'deposit_amount' => 'required|regex:(^[0-9]+(\.[0-9]{1,2})?$)',
		]);
		
		$user_empiya_account_type = $request->user_empiya_account_type;
		$mtn_money_number = $request->mtn_money_number;
		$deposit_amount = $request->deposit_amount;
		
		return redirect()->route('get-confirm-mtn-request-payment', array($transaction_type_slug, $provider_slug, $user_empiya_account_type, $mtn_money_number, $deposit_amount));
	}
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function requestPaymentConfirmGet(EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug, $user_empiya_account_type, $mtn_money_number, $deposit_amount)
	{
		// get authenticated user
		$user = auth()->user();
		$data['user'] = $user;
		
		// user form data
		$user_empiya_account_type_id = $user_empiya_account_type;
		$data['receiver_empiya_account_type'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->where('empiya_account_type_id', $user_empiya_account_type_id)->first();
		
		$data['mtn_money_number'] = $mtn_money_number;
		$data['deposit_amount'] = $deposit_amount;
		
		// transaction type slug
		$data['transaction_type_slug'] = $transaction_type_slug;
		
		// provider model
		$data['provider_slug'] = $provider_slug;
		
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(1);
		// heading
		$data['heading'] = "Confirm Deposit from MTN to e-Mpiya";
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		return view('empiya.mtn.confirm_deposit', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
	}
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function requestPayment(EmpiyaTransactionType $transaction_type_slug, EmpiyaProvider $provider_slug, Request $request)
	{
		$this->validate($request, [
			'user_empiya_account' => 'required',
			'mtn_money_number' => 'required|regex:(^096\d{7}$)',
			'deposit_amount' => 'required|regex:(^[0-9]+(\.[0-9]{1,2})?$)',
		]);
		// XML curl POST Request Payment
		function doXMLCurl($url,$postXML){
			$headers = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				"SOAPAction: \"run\"",
				"Content-length: ".strlen($postXML),
				"Host:127.0.0.1",
				"Cookie: sessionid=" . Session::getId(),
			); 
			$CURL = curl_init();

			curl_setopt($CURL, CURLOPT_URL, $url); 
			curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
			curl_setopt($CURL, CURLOPT_POST, 1); 
			curl_setopt($CURL, CURLOPT_POSTFIELDS, $postXML); 
			curl_setopt($CURL, CURLOPT_HEADER, false); 
			curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
			$xmlResponse = curl_exec($CURL); 

			return $xmlResponse;
		}
		// logged in user
		$user = auth()->user();
		
		// client properties
		// RequestPayment URL
		$REQPAYEMENTURL = "http://localhost:8088/RequestPaymentResponse";

		// Request Payment Deposit URL
		$REQDEPOSITURL = "http://localhost:8088/DepositMobileMoneyResponse";

		// Mobile Money ECW Version(1.5/1.7)
		$ECW_VERSION = 1.7;

		// Header Details
		// Service Partner ID
		$spId = 35000004;
		
		// SDP Password
		$Password = "bmeB500";
		
		// Service ID
		$serviceId = 3500001;

		// Sender ID
		$senderId = 452;

		// Bundle ID
		$bundleID = 123;

		// Request Body Information(Both Payment & Deposit)
		// MSISDNNum
		$MSISDNNum = $request->mtn_money_number;
		
		// Minimum due amount for request payment API
		$MinDueAmount = 0;

		// Opco ID
		$opCoId = 26001;

		// Prefered Language
		$prefLang = "En";

		// Narration details
		$Narration = "Deposit to e-Mpiya Account from MTN Money";

		// Order time for deposit money
		$orderDateTime = 124585123;

		// User IMSI number for Deposit Money
		$imsiNum = 552;

		// Currency Code
		$currencyCode = 22;
		
		// timeStamp
		$timeStamp = date("YmdHis");
		
		// spPassword
		$spPassword = md5($spId + $Password + $timeStamp);
		
		// e-Mpiya client App generated
		// transaction number
		$ProcessingNumber = "OMPS123456789";
		
		// user account number
		$user_account = User::find($user->id)->empiyaAccounts()->where('empiya_account_type_id', $request->user_empiya_account)->get()->first();
		$AcctRef = $user_account->account_number;
		
		// user account balance
		// App\Models\EmpiyaTransactionHistory::whereUserId(1)->orderBy('created_at', 'DESC')->get()->first()->final_balance;
		$AcctBalance = 1000;
		
		// DueAmount
		$DueAmount = $request->deposit_amount;
		
		$REQUEST_BODY= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0">
	<soapenv:Header>
		<RequestSOAPHeader xmlns="http://www.huawei.com.cn/schema/common/v2_1">
			<spId>$spId</spId>
			<spPassword>$spPassword</spPassword>
			<bundleID>$bundleID</bundleID>
			<serviceId>$serviceId</serviceId>
			<timeStamp>$timeStamp</timeStamp>
		</RequestSOAPHeader>
	</soapenv:Header>
	<soapenv:Body>
		<b2b:processRequest>
			<serviceId>200</serviceId>
			<parameter>
				<name>DueAmount</name>
				<value>$DueAmount</value>
			</parameter>
			<parameter>
				<name>MSISDNNum</name>
				<value>$MSISDNNum</value>
			</parameter>
			<parameter>
				<name>ProcessingNumber</name>
				<value>$ProcessingNumber</value>
			</parameter>
			<parameter>
				<name>serviceId</name>
				<value>200</value>
			</parameter>
			<parameter>
				<name>AcctRef</name>
				<value>$AcctRef</value>
			</parameter>
			<parameter>
				<name>AcctBalance</name>
				<value>$AcctBalance</value>
			</parameter>
			<parameter>
				<name>MinDueAmount</name>
				<value>$MinDueAmount</value>
			</parameter>
			<parameter>
				<name>Narration</name>
				<value>$Narration</value>
			</parameter>
			<parameter>
				<name>PrefLang</name>
				<value>121212121</value>
			</parameter>
			<parameter>
				<name>OpCoID</name>
				<value>$opCoId</value>
			</parameter>
		</b2b:processRequest>
	</soapenv:Body>
</soapenv:Envelope>
XML;
		try {
			$full_response = doXMLCurl('http://127.0.0.1:8088/RequestPaymentResponse', $REQUEST_BODY);
			$response_xml = new \SimpleXMLElement(strstr($full_response, '<'), LIBXML_NOERROR);
		} catch (\Exception $e) {
			return redirect()->back()->withInput()->with('server_error', 'Server Unreachable. Please try again.');
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
		$mtn_liability_account = 1;
		$transaction->sender_account_id = $mtn_liability_account;
		// receiver
		//$transaction->receiver_id = $user->id;
		$receiver_account_id = EmpiyaAccount::where('user_id', $user->id)->where('empiya_account_type_id', $request->user_empiya_account)->get()->first();
		$transaction->receiver_account_id = $receiver_account_id->id;
		$transaction->amount = $request->deposit_amount;
		$transaction->transaction_fee = 0.00;
		$transaction->empiya_transaction_type_id = $transaction_type_slug->id;
		$transaction->description = "Deposit from " . $request->mtn_money_number . " MTN Money to e-Mpiya " . $user_account->account_type . " " . $AcctRef;
		// raw description
		$raw_description = "";
		foreach ($response_xml->xpath('//return') as $return) {
			$raw_description .= "//" . $return->name . " " . $return->value;
		}
		$transaction->raw_description = $raw_description;
		
		$transaction->empiya_transaction_status_id = 5;
		
		// generate OTP
		$digits = 4;
		$otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
		$transaction->otp = $otp;
		
		$transaction->save();
		
		// Send OTP email
		try {
			if (!is_null($user->email)) {
				Mail::send('emails.otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
					$message->from('info@oneziko.com', 'One Ziko Info');
					$message->to('oneziko@localhost.net', $user->username)->subject('Confirm Deposit Using Your e-Mpiya Account');
				});
			}
		} catch (\Exception $e) {
			return redirect()->back()->withInput()->with('email_error', 'Unable to send OTP. Please try again.');
		}
		// create transaction history for liability account
		// $last_liability_account_transaction = EmpiyaAccount::where('id', $mtn_liability_account)->join('empiya_transactions', 'empiya_accounts.id', '=', 'empiya_transactions.sender_account_id')->orderBy('created_at', 'DESC')->get()->first();
		$last_liability_account_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $mtn_liability_account)->orderBy('created_at', 'DESC')->get()->first();
		$liability_transaction_history = new EmpiyaTransactionHistory;
		$liability_transaction_history->empiya_transaction_id = $transaction->id;
		$liability_transaction_history->empiya_account_id = $mtn_liability_account;
		$liability_transaction_history->is_debit = 1;
		// get initial balance
		if (isset($last_liability_account_transaction_history)) {
			$liability_transaction_history->initial_balance = $last_liability_account_transaction_history->final_balance;
		} else {
			$liability_transaction_history->initial_balance = 0.00;
		}
		// calculate final balance of credited user
		if ($liability_transaction_history->is_debit == 0) {
			$liability_transaction_history->final_balance = $liability_transaction_history->initial_balance - $transaction->amount; // not debit (credit): subtract since liability
		} else {
			$liability_transaction_history->final_balance = $liability_transaction_history->initial_balance + $transaction->amount; // debit: add since liability
		}
		$liability_transaction_history->save();
		// create transaction history for recipient
		$last_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $receiver_account_id->id)->orderBy('created_at', 'DESC')->get()->first();
		$transaction_history = new EmpiyaTransactionHistory;
		$transaction_history->empiya_transaction_id = $transaction->id;
		$transaction_history->empiya_account_id = $receiver_account_id->id;
		$transaction_history->is_debit = 0;
		// get initial balance
		if (isset($last_transaction_history)) {
			$transaction_history->initial_balance = $last_transaction_history->final_balance;
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
		
		return redirect()->route('complete-new-transaction', array($transaction_type_slug->transaction_type_slug, $provider_slug->provider_slug, $transaction->id));
	}
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function depositMobileMoney(Request $request)
	{
		$this->validate($request, [
			'user_empiya_account' => 'required',
			'mtn_money_number' => 'required|regex:(^096\d{7}$)',
			'withdraw_amount' => 'required|regex:(^[0-9]+(\.[0-9]{1,2})?$)',
		]);
		// XML curl POST Request Payment
		function doXMLCurl($url,$postXML){
			$headers = array(
				"Content-type: text/xml;charset=\"utf-8\"",
				"Accept: text/xml",
				"Cache-Control: no-cache",
				"Pragma: no-cache",
				"SOAPAction: \"run\"",
				"Content-length: ".strlen($postXML),
				"Host:127.0.0.1",
				"Cookie: sessionid=" . Session::getId(),
			); 
			$CURL = curl_init();

			curl_setopt($CURL, CURLOPT_URL, $url); 
			curl_setopt($CURL, CURLOPT_HTTPAUTH, CURLAUTH_BASIC); 
			curl_setopt($CURL, CURLOPT_POST, 1); 
			curl_setopt($CURL, CURLOPT_POSTFIELDS, $postXML); 
			curl_setopt($CURL, CURLOPT_HEADER, false); 
			curl_setopt($CURL, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($CURL, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($CURL, CURLOPT_RETURNTRANSFER, true);
			$xmlResponse = curl_exec($CURL); 

			return $xmlResponse;
		}
		// logged in user
		$user = auth()->user();
		
		// client properties
		// RequestPayment URL
		$REQPAYEMENTURL = "http://localhost:8088/RequestPaymentResponse";

		// Request Payment Deposit URL
		$REQDEPOSITURL = "http://localhost:8088/DepositMobileMoneyResponse";

		// Mobile Money ECW Version(1.5/1.7)
		$ECW_VERSION = 1.7;

		// Header Details
		// Service Partner ID
		$spId = 35000004;
		
		// SDP Password
		$Password = "bmeB500";
		
		// Service ID
		$serviceId = 102;

		// Sender ID
		$SenderID = "MOM";

		// Bundle ID
		$bundleID = 123;

		// Request Body Information(Both Payment & Deposit)
		// MSISDNNum
		$MSISDNNum = $request->mtn_money_number;
		
		// Minimum due amount for request payment API
		$MinDueAmount = 0;

		// Opco ID
		$OpCoID = 26001;

		// Prefered Language
		$PrefLang = "En";

		// Narration details
		$Narration = "Withdraw from e-Mpiya Account and Deposit in MTN Money Account";

		// Order time for deposit money
		$orderDateTime = 124585123;

		// User IMSI number for Deposit Money
		$IMSINum = 86;

		// Currency Code
		$currencyCode = 22;
		
		// timeStamp
		$timeStamp = date("YmdHis");
		
		// spPassword
		$spPassword = md5($spId + $Password + $timeStamp);
		
		// e-Mpiya client App generated
		// transaction number
		$ProcessingNumber = "OMPS123456789";
		
		// user account number
		$AcctRef = User::find($user->id)->empiyaAccounts()->where('empiya_account_type_id', $request->user_empiya_account)->get()->first()->account_number;
		
		// user account balance
		// App\Models\EmpiyaTransactionHistory::whereUserId(1)->orderBy('created_at', 'DESC')->get()->first()->final_balance;
		$AcctBalance = 1000;
		
		// DueAmount
		$Amount = $request->withdraw_amount;
		
		// Order Date Time
		$OrderDateTime = $timeStamp;
		
		$REQUEST_BODY= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0/">
	<soapenv:Header>
		<RequestSOAPHeader xmlns="http://www.huawei.com.cn/schema/common/v2_1">
			<spId>$spId</spId>
			<spPassword>$spPassword</spPassword>
			<bundleID>$bundleID</bundleID>
			<serviceId>35000001000035</serviceId>
			<timeStamp>$timeStamp</timeStamp>
		</RequestSOAPHeader>
	</soapenv:Header>
	<soapenv:Body>
		<b2b:processRequest>
			<serviceId>201</serviceId>
			<parameter>
				<name>ProcessingNumber</name>
				<value>$ProcessingNumber</value>
			</parameter>
			<parameter>
				<name>serviceId</name>
				<value>$serviceId</value>
			</parameter>
			<parameter>
				<name>SenderID</name>
				<value>$SenderID</value>
			</parameter>
			<parameter>
				<name>PrefLang</name>
				<value>$PrefLang</value>
			</parameter>
			<parameter>
				<name>OpCoID</name>
				<value>$OpCoID</value>
			</parameter>
			<parameter>
				<name>MSISDNNum</name>
				<value>$MSISDNNum</value>
			</parameter>
			<parameter>
				<name>Amount</name>
				<value>$Amount</value>
			</parameter>
			<parameter>
				<name>Narration</name>
				<value>$Narration</value>
			</parameter>
			<parameter>
				<name>IMSINum</name>
				<value>$IMSINum</value>
			</parameter>
			<parameter>
				<name>OrderDateTime</name>
				<value>$OrderDateTime</value>
			</parameter>
		</b2b:processRequest>
	</soapenv:Body>
</soapenv:Envelope>
XML;
		try {
			$full_response = doXMLCurl('http://127.0.0.1:8088/DepositMobileMoneyResponse', $REQUEST_BODY);
			$response_xml = new \SimpleXMLElement(strstr($full_response, '<'), LIBXML_NOERROR);
		} catch (\Exception $e) {
			return redirect()->back()->withInput()->with('server_error', 'Server Unreachable. Please try again.');
		}
		$data['response_xml'] = $response_xml;
		
		// view variables
		
		return view('empiya.view_transactions', $data)->nest('right_sidebar', 'layouts.right_sidebar', $data);
	}
}
