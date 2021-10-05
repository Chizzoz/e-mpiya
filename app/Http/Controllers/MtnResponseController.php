<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\AccessPlatform;
use App\Models\ContentType;
use App\Models\EmpiyaAccount;
use App\Models\EmpiyaAccountType;
use App\Models\EmpiyaProvider;
use App\Models\EmpiyaTransaction;
use App\Models\EmpiyaTransactionHistory;
use App\Models\EmpiyaTransactionType;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Mail;
use Redirect;
use Session;
use SimpleXMLElement;

class MtnResponseController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function confirmThirdPartyPayment()
	{
		// get incoming SOAP request contents
		try {
			$full_request = file_get_contents("php://input");
		} catch (\Exception $e) {
			$ERROR_RESPONSE= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0/">
	<soapenv:Header/>
	<soapenv:Body>
		<b2b:processRequestResponse>
			<return>
				<name>Error</name>
				<value>No data found</value>
			</return>
		</b2b:processRequestResponse>
	</soapenv:Body>
</soapenv:Envelope>
XML;
			return $ERROR_RESPONSE;
		}
		// get SOAP request XML
		$request_xml = new \SimpleXMLElement(strstr($full_request, '<'), LIBXML_NOERROR);
		
		// get an array of SOAP request parameters
		foreach ($request_xml->xpath('//parameter') as $parameter) {
			switch($parameter->name) {
				case "ProcessingNumber":
					$ProcessingNumber = $parameter->value;
					break;
				case "senderID":
					$senderID = $parameter->value;
					break;
				case "AcctRef":
					$AcctRef = $parameter->value;
					break;
				case "RequestAmount":
					$RequestAmount = $parameter->value;
					break;
				case "paymentRef":
					$paymentRef = $parameter->value;
					break;
				case "ThirdPartyTransactionID":
					$ThirdPartyTransactionID = $parameter->value;
					break;
				case "MOMAcctNum":
					$MOMAcctNum = $parameter->value;
					break;
				case "CustName":
					$CustName = $parameter->value;
					break;
				case "TXNType":
					$TXNType = $parameter->value;
					break;
				case "StatusCode":
					$StatusCode = $parameter->value;
					break;
				case "OpCoID":
					$OpCoID = $parameter->value;
					break;
				case "MerchantName":
					$MerchantName = $parameter->value;
					break;
				default:
					echo "empty request";
			}
		}
		
		// logged in user
		$user = auth()->user();
		
		// client properties
		// Header Details
		// e-Mpiya client App generated
		// status code
		$StatusCode = 01;
		
		// status description code
		$StatusDesc = "Successfully Processed Transaction.";
		
		// token
		$Token = 121212;
		
		// generate response
		$RESPONSE_BODY= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0/">
	<soapenv:Header/>
	<soapenv:Body>
		<b2b:processRequestResponse>
			<return>
				<name>ProcessingNumber</name>
				<value>$ProcessingNumber</value>
			</return>
			<return>
				<name>StatusCode</name>
				<value>$StatusCode</value>
			</return>
			<return>
				<name>StatusDesc</name>
				<value>$StatusDesc</value>
			</return>
			<return>
				<name>ThirdPartyAcctRef</name>
				<value>$AcctRef</value>
			</return>
			<return>
				<name>Token</name>
				<value>$Token</value>
			</return>
		</b2b:processRequestResponse>
	</soapenv:Body>
</soapenv:Envelope>
XML;
	
		return $RESPONSE_BODY;
	}
	/**
	*	Query Third Party e-Mpiya Account balance 
	**/
	public function queryThirdPartyAccount()
	{
		// get incoming SOAP request contents
		try {
			$full_request = file_get_contents("php://input");
		} catch (\Exception $e) {
			$ERROR_RESPONSE= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0/">
	<soapenv:Header/>
	<soapenv:Body>
		<b2b:processRequestResponse>
			<return>
				<name>Error</name>
				<value>No data found</value>
			</return>
		</b2b:processRequestResponse>
	</soapenv:Body>
</soapenv:Envelope>
XML;
			return $ERROR_RESPONSE;
		}
		// get SOAP request XML
		$request_xml = new \SimpleXMLElement(strstr($full_request, '<'), LIBXML_NOERROR);
		
		// get an array of SOAP request parameters
		foreach ($request_xml->xpath('//parameter') as $parameter) {
			switch($parameter->name) {
				case "ProcessingNumber":
					$ProcessingNumber = $parameter->value;
					break;
				case "senderID":
					$senderID = $parameter->value;
					break;
				case "AcctRef":
					$AcctRef = $parameter->value;
					break;
				case "OpCoID":
					$OpCoID = $parameter->value;
					break;
				default:
					echo "empty request";
			}
		}
		
		// logged in user
		$user = auth()->user();
		
		// client properties
		// Header Details
		// e-Mpiya client App generated
		// Due Amount
		$DueAmount = 2121;
		
		// Balance Amount
		$BalanceAmount = 121212;
		
		// Min Due Amount
		$MinDueAmount = 2121;
		
		// Narration
		$Narration = "Query User e-Mpiya Account balance ";
		
		// Status Code
		$StatusCode = 01;
		
		// Status Desc
		$StatusDesc = "Successfully Verified User e-Mpiya Account Balance";
		
		// generate response
		$RESPONSE_BODY= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0/">
	<soapenv:Header/>
	<soapenv:Body>
		<b2b:processRequestResponse>
			<return>
				<name>DueAmount</name>
				<value>$DueAmount</value>
			</return>
			<return>
				<name>BalanceAmount</name>
				<value>$BalanceAmount</value>
			</return>
			<return>
				<name>MinDueAmount</name>
				<value>$MinDueAmount</value>
			</return>
			<return>
				<name>Narration</name>
				<value>$Narration</value>
			</return>
			<return>
				<name>ProcessingNumber</name>
				<value>$ProcessingNumber</value>
			</return>
			<return>
				<name>StatusCode</name>
				<value>$StatusCode</value>
			</return>
			<return>
				<name>ThirdPartyAcctRef</name>
				<value>$AcctRef</value>
			</return>
			<return>
				<name>StatusDesc</name>
				<value>$StatusDesc</value>
			</return>
		</b2b:processRequestResponse>
	</soapenv:Body>
</soapenv:Envelope>
XML;
	
		return $RESPONSE_BODY;
	}
	/**
	*	Request Payment Completed Response
	**/
	public function requestPaymentCompleted()
	{
		// get incoming SOAP request contents
		try {
			$full_request = file_get_contents("php://input");
		} catch (\Exception $e) {
			$ERROR_RESPONSE= <<<XML
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:b2b="http://b2b.mobilemoney.mtn.zm_v1.0/">
	<soapenv:Header/>
	<soapenv:Body>
		<b2b:processRequestResponse>
			<return>
				<name>Error</name>
				<value>No data found</value>
			</return>
		</b2b:processRequestResponse>
	</soapenv:Body>
</soapenv:Envelope>
XML;
			return $ERROR_RESPONSE;
		}
		// get SOAP request XML
		$response_xml = new \SimpleXMLElement(strstr($full_request, '<'), LIBXML_NOERROR);
		
		// get an array of SOAP request parameters
		foreach ($response_xml->xpath('//*[name()=\'ns3:requestPaymentCompleted\']/*') as $body) {
			$name = $body->getName();
			switch($name) {
				case "ProcessingNumber":
					$ProcessingNumber = strval($body);
					break;
				case "MOMTransactionID":
					$MOMTransactionID = strval($body);
					break;
				case "StatusCode":
					$StatusCode = strval($body);
					break;
				case "StatusDesc":
					$StatusDesc = strval($body);
					break;
				case "ThirdPartyAcctRef":
					$ThirdPartyAcctRef = strval($body);
					break;
				default:
					echo "empty request";
			}
		}
		
		// logged in user
		$user = auth()->user();
		
		// client properties
		// Header Details
		// e-Mpiya client App generated
		// Result code
		$resultCode = "00000000";
		
		// Result Description
		$resultDescription = "success";
		
		// Result value
		$value = "success";
		
		// generate response
		$RESPONSE_BODY= <<<XML
<?xml version="1.0" encoding="utf-8"?>
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/">
	<soapenv:Body>
		<requestPaymentCompletedResponse xmlns="http://www.csapi.org/schema/momopayment/local/v1_0">
			<result>
				<resultCode xmlns="">$resultCode</resultCode>
				<resultDescription xmlns="">$resultDescription</resultDescription>
			</result>
			<extensionInfo>
				<item xmlns="">
					<key>result</key>
					<value>$value</value>
				</item>
			</extensionInfo>
		</requestPaymentCompletedResponse>
	</soapenv:Body>
</soapenv:Envelope>
XML;
	
		return $RESPONSE_BODY;
	}
	
	// merchant payment request
    public function merchantPurchaseRequest(Request $request)
    {
		$this->validate($request, [
            'merchant_id' => 'required|max:255',
            'amount' => 'required|numeric|regex:(^[0-9]+(\.[0-9]{1,2})?$)',
			'empiya_account_number' => 'required|numeric|digits:13',
		]);
		
		$merchant_id = $request->merchant_id;
		$amount = $request->amount;
		$empiya_account_number = $request->empiya_account_number;
		$item = $request->item;
		$transaction_type_id = 2;
		
		// return data
		$data['merchant_id'] = $merchant_id;
		$data['amount'] = $amount;
		$data['empiya_account_number'] = $empiya_account_number;
		$data['item'] = $item;
		
		// user form data
		$user_empiya_account = EmpiyaAccount::where('account_number', $empiya_account_number)->get()->first();
		$data['user_empiya_account_type'] = EmpiyaAccountType::where('id', $user_empiya_account->empiya_account_type_id)->get()->first();
		
		// check balance
		$user_recent_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $user_empiya_account->id)->orderBy('created_at', 'DESC')->get()->first();
		if ($user_recent_transaction_history->final_balance > $amount) {
			$data['balance'] = $balance = 1;
		} else {
			$data['balance'] = $balance = 0;
		}
		// get user
		$user = User::whereId($user_empiya_account->user_id)->get()->first();
		$data['user'] = $user;
		
		//$data['mtn_money_number'] = $request->mtn_money_number;
		//$data['deposit_amount'] = $request->deposit_amount;
		
		// create transaction
		// store transaction
		$transaction = new EmpiyaTransaction;
		$transaction->empiya_provider_id = 5;
		// generate transaction reference number
		$merchant = $merchant_id;
		$date = date("dmy");
		$time = date("His");
		$now = date("Y-m-d H:i:s");
		$sequence = EmpiyaTransaction::where('created_at', $now)->count() + 1;
		$currency = "01";
		$transaction->reference_number = $merchant . strtoupper(dechex($date)) . strtoupper(dechex($time)) . strtoupper(dechex($sequence)) . strtoupper(dechex($currency));
		// sender
		//$transaction->sender_id = 1;
		$transaction->sender_account_id = $user_empiya_account->id;
		// receiver
		//$transaction->receiver_id = $user->id;
		$merchant_account = EmpiyaAccount::where('account_name', $merchant_id)->get()->first();
		$transaction->receiver_account_id = $merchant_account->id;;
		$transaction->amount = $request->amount;
		$transaction->transaction_fee = 0.00;
		$transaction->empiya_transaction_type_id = $transaction_type_id;
		$transaction->description = "Purchase of " . $item . " from Merchant: " . $merchant_id . " valued at " . $amount . " using account: " . $empiya_account_number;
		// raw description
		$raw_description = "//merchant_id " . $merchant_id . "//amount " . $amount . "//empiya_account_number " . $empiya_account_number . "//item " . $item . "//transaction_type_id " . $transaction_type_id;
		$transaction->raw_description = $raw_description;
		
		// generate OTP
		$digits = 4;
		$otp = str_pad(rand(0, pow(10, $digits)-1), $digits, '0', STR_PAD_LEFT);
		$transaction->otp = $otp;
		
		if ($balance == 0) {
			$transaction->empiya_transaction_status_id = 6;
		} else {
			$transaction->empiya_transaction_status_id = 5;
		}
		$transaction->save();
		$data['transaction_id'] = $transaction->id;
		// transaction type slug
		$data['transaction_type_slug'] = "purchase";
		
		// provider model
		//$data['provider_slug'] = $provider_slug;
		
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(1);
		// heading
		$data['heading'] = "Confirm Buy Using e-Mpiya";
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		// Send OTP email
		try {
			if (!is_null($user->email)) {
				Mail::send('emails.otp', ['user' => $user, 'otp' => $otp], function ($message) use ($user) {
					$message->from('info@oneziko.com', 'One Ziko Info');
					$message->to('oneziko@localhost.net', $user->username)->subject('Confirm Payment Using Your e-Mpiya Account');
				});
			}
		} catch (\Exception $e) {
			return Redirect::away('http://localhost/zedstore.com/public/error');
		}
		
		return redirect()->route('merchant-purchase-confirm', array($merchant_id, $amount, $empiya_account_number, $item, $transaction));
	}
	
	// merchant payment request
    public function merchantPurchaseConfirm($merchant_id, $amount, $empiya_account_number, $item, EmpiyaTransaction $transaction)
    {
		// return data
		$data['merchant_id'] = $merchant_id;
		$data['amount'] = $amount;
		$data['empiya_account_number'] = $empiya_account_number;
		$data['item'] = $item;
		
		// user form data
		$user_empiya_account = EmpiyaAccount::where('account_number', $empiya_account_number)->get()->first();
		$data['user_empiya_account_type'] = EmpiyaAccountType::where('id', $user_empiya_account->empiya_account_type_id)->get()->first();
		
		// check balance
		$user_recent_transaction_history = EmpiyaTransactionHistory::where('empiya_account_id', $user_empiya_account->id)->orderBy('created_at', 'DESC')->get()->first();
		if ($user_recent_transaction_history->final_balance > $amount) {
			$data['balance'] = 1;
		} else {
			$data['balance'] = 0;
		}
		// get user
		$user = User::whereId($user_empiya_account->user_id)->get()->first();
		$data['user'] = $user;
		
		// transaction
		$data['transaction_id'] = $transaction->id;
		// transaction type slug
		$data['transaction_type_slug'] = "purchase";
		
		// provider model
		//$data['provider_slug'] = $provider_slug;
		
		// Access Platform
		$data['platform'] = AccessPlatform::find(3);
		// content type
		$data['content_type'] = ContentType::find(1);
		// heading
		$data['heading'] = "Confirm Buy Using e-Mpiya";
		
		// get e-Mpiya transaction types
		$data['transaction_types'] = EmpiyaTransactionType::orderBy('transaction_type', 'ASC')->get();
		
		// get e-Mpiya transaction providers
		$data['providers'] = EmpiyaProvider::orderBy('provider', 'ASC')->get();
		
		// get user empiya account
		$data['user_empiya_accounts'] = EmpiyaAccount::whereUserId($user->id)->join('empiya_account_types', 'empiya_accounts.empiya_account_type_id', '=', 'empiya_account_types.id')->get();
		
		return view('empiya.confirm_purchase', $data);
	}
	
	// merchant payment complete
    public function merchantPurchaseComplete(Request $request)
    {
		// transaction
		$transaction = EmpiyaTransaction::whereId($request->transaction_id)->get()->first();
		// assign otp to validation field
		$request['one_time_password_sent'] = $transaction->otp;
		
		$this->validate($request, [
            'transaction_id' => 'required',
            'otp' => 'required|same:one_time_password_sent',
		]);
		
		// complete transaction
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
		
		return Redirect::away('http://localhost/zedstore.com/public/');
	}
	/**
	*	deposit from MTN Money into e-Mpiya Account
	**/
	public function requestPaymentViaSms($mobile_number, $deposit_amount)
	{
		$user_mobile = UserMobile::where('user_mobile_number', $mobile_number)->get()->first();
		$user_empiya_account = EmpiyaAccount::whereUserId($user_mobile->user_id)->get()->first();
		$mtn_money_number = $mobile_number;
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
		$MSISDNNum = $mtn_money_number;
		
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
		$user_account = User::find($user->id)->empiyaAccounts()->where('empiya_account_type_id', $user_empiya_account)->get()->first();
		$AcctRef = $user_account->account_number;
		
		// user account balance
		// App\Models\EmpiyaTransactionHistory::whereUserId(1)->orderBy('created_at', 'DESC')->get()->first()->final_balance;
		$AcctBalance = 1000;
		
		// DueAmount
		$DueAmount = $deposit_amount;
		
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
		$merchant = "SMS";
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
		
		$transaction->empiya_transaction_status_id = 3;
		$transaction->save();
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
		
		return $transaction;
	}
}
