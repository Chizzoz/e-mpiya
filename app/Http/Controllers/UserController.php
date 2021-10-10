<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Mail;
use App\Models\Area;
use App\Models\CompanyUser;
use App\Models\CompanyUserSpecific;
use App\Models\Content;
use App\Models\Country;
use App\Models\District;
use App\Models\EmpiyaAccount;
use App\Models\EmpiyaAccountLimit;
use App\Models\EmpiyaAccountType;
use App\Models\FactsContent;
use App\Models\GroupUser;
use App\Models\GroupUserSpecific;
use App\Models\HeadlinesContent;
use App\Models\IndividualUser;
use App\Models\IndividualUserSpecific;
use App\Models\Location;
use App\Models\MobileNetworkOperator;
use App\Models\Province;
use App\Models\UserAccess;
use App\Models\UserHeadlineSourcePreference;
use App\Models\UserMobile;
use App\Models\UserRelationship;
use App\Models\UserType;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Requested;
use Illuminate\Support\Str;
use Image;

class UserController extends Controller
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
	// User assign defaults
	public function userAssignDefaults()
	{
		$user = auth()->user();
		$user_empiya_account = User::whereUserId($user->id)->join('empiya_accounts', 'users.id', '=', 'empiya_accounts.user_id')->get()->first();
		$user_empiya_account_limit = EmpiyaAccount::where('user_id', $user->id)->join('empiya_account_limits', 'empiya_accounts.id', '=', 'empiya_account_limits.empiya_account_id')->get()->first();
		if ($user->is_active != 1) {
			// create user e-Mpiya account
			if (!isset($user_empiya_account)) {
				$empiya_account = new EmpiyaAccount;
				$empiya_account->user_id = $user->id;
				// generate unique account number
				$empiya_account->empiya_account_type_id = $user->user_type_id;
				$empiya_account->empiya_currency_id = 1;
				$empiya_account->save();
				$empiya_account->account_number = 1000000000 + $empiya_account->id;
				$empiya_account->save();
			}
			// set default account limit
			if (!isset($user_empiya_account_limit)) {
				$account_limit = new EmpiyaAccountLimit;
				if (isset($empiya_account)) {
					$account_limit->empiya_account_id = $empiya_account->id;
				} else {
					$account_limit->empiya_account_id = $user_empiya_account->id;
				}
				$account_limit->empiya_account_limit_type_id = 3;
				$account_limit->account_limit = 10000.00;
				$account_limit->save();
			}
			// Activate user
			$user->is_active = 1;
			$user->save();
			// User instantiate
			if ($user->user_type_id == 1) {
				$company_user = CompanyUser::whereUserId($user->id)->first();
				if (is_null($company_user)) {
					$new_company_user = new CompanyUser;
					$new_company_user->user_id = $user->id;
					$new_company_user->save();
				}
			} elseif ($user->user_type_id == 2) {
				$group_user = GroupUser::whereUserId($user->id)->first();
				if (is_null($group_user)) {
					$new_group_user = new GroupUser;
					$new_group_user->user_id = $user->id;
					$new_group_user->save();
				}
			} elseif ($user->user_type_id == 3) {
				$individual_user = IndividualUser::whereUserId($user->id)->first();
				if (is_null($individual_user)) {
					$new_individual_user = new IndividualUser;
					$new_individual_user->user_id = $user->id;
					$new_individual_user->save();
				}
			}
			// User mobile instantiate
			$user_mobile = UserMobile::whereUserId($user->id)->first();
			if (is_null($user_mobile)) {
				$new_user_mobile = new UserMobile;
				$new_user_mobile->user_id = $user->id;
				$new_user_mobile->save();
			}
			// Send welcome email
			if (!is_null($user->email)) {
				Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
					$message->from('info@oneziko.com', 'One Ziko Info');
					$message->to($user->email, $user->username)->subject('Welcome to e-Mpiya OMPS (Online & Mobile Payment System)');
				});
			}
		} elseif (!isset($user_empiya_account)) {
			// create user e-Mpiya account
			$empiya_account = new EmpiyaAccount;
			$empiya_account->user_id = $user->id;
			$empiya_account->empiya_account_type_id = $user->user_type_id;
			$empiya_account->empiya_currency_id = 1;
			$empiya_account->save();
			$empiya_account->account_number = 1000000000 + $empiya_account->id;
			$empiya_account->save();
			
			// set default account limit
			if (!isset($user_empiya_account_limit)) {
				$account_limit = new EmpiyaAccountLimit;
				if (isset($empiya_account)) {
					$account_limit->empiya_account_id = $empiya_account->id;
				} else {
					$account_limit->empiya_account_id = $user_empiya_account->id;
				}
				$account_limit->empiya_account_limit_type_id = 3;
				$account_limit->account_limit = 1000.00;
				$account_limit->save();
			}
			
			// Send welcome email
			if (!is_null($user->email)) {
				Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
					$message->from('info@oneziko.com', 'One Ziko Info');
					$message->to($user->email, $user->username)->subject('Welcome to e-Mpiya OMPS (Online & Mobile Payment System)');
				});
			}
			if (isset($empiya_account)) {
				$empiya_account_type_slug = EmpiyaAccountType::whereId($empiya_account->empiya_account_type_id)->get()->first();
				return redirect(route('account-overview', $empiya_account_type_slug->account_type_slug));
			} else {
				$empiya_account_type_slug = EmpiyaAccountType::whereId($user_empiya_account->empiya_account_type_id)->get()->first();
				return redirect(route('account-overview', $empiya_account_type_slug->account_type_slug));
			}
		} else {
			if (isset($empiya_account)) {
				$empiya_account_type_slug = EmpiyaAccountType::whereId($empiya_account->empiya_account_type_id)->get()->first();
				return redirect(route('account-overview', $empiya_account_type_slug->account_type_slug));
			} else {
				$empiya_account_type_slug = EmpiyaAccountType::whereId($user_empiya_account->empiya_account_type_id)->get()->first();
				return redirect(route('account-overview', $empiya_account_type_slug->account_type_slug));
			}
		}
			if (isset($empiya_account)) {
				$empiya_account_type_slug = EmpiyaAccountType::whereId($empiya_account->empiya_account_type_id)->get()->first();
				return redirect(route('account-overview', $empiya_account_type_slug->account_type_slug));
			} else {
				$empiya_account_type_slug = EmpiyaAccountType::whereId($user_empiya_account->empiya_account_type_id)->get()->first();
				return redirect(route('account-overview', $empiya_account_type_slug->account_type_slug));
			}
	}
	// View user profile
	public function viewUserProfile(User $user)
    {
		// CreativeContent
		$contents = DB::table('contents')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->join('creative_contents', 'contents.id', '=', 'creative_contents.content_id')->join('creative_content_types', 'creative_contents.creative_content_type_id', '=', 'creative_content_types.id')->where('content_type_id', 1)->where('contents.user_id', $user->id)->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->orderBy('contents.created_at', 'DESC');
		// get random Zambian Headline
		//$data['random_headline'] = Content::where('content_type_id', 7)->where('created_at', '>', date('Y-m-d G:i:s', time()-8640000))->get()->random(1);
		// Associate relationship stuff
		$data['user_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '!=', 4)->select('relationships.id AS id', 'associators.id AS associator_id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.id AS associated_id', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'relationships.user_relationship_status_id AS user_relationship_status_id', 'relationships.initiated_by_id AS initiated_by_id', 'relationships.accepted_by_id AS accepted_by_id')->get();
		$data['pending_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->where('relationships.user_relationship_status_id', 1)->where('associated_id', $user->id)->select('relationships.id AS id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associators.id AS associator_id', 'associators.user_profile_picture AS associator_profile_picture', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'associateds.id AS associated_id', 'associateds.user_profile_picture AS associated_profile_picture')->get();
		$data['pending_delete_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS initiators', 'relationships.initiated_by_id', '=', 'initiators.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '=', 3)->where('relationships.user_relationship_status_id', '!=', 4)->where('relationships.initiated_by_id', '!=', $user->id)->select('relationships.id AS id', 'relationships.initiated_by_id AS initiator_id', 'initiators.username AS initiator_name', 'initiators.username_slug AS initiator_username_slug')->get();
		$data['relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '=', 2)->select('relationships.id AS id', 'associators.id AS associator_id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.id AS associated_id', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'relationships.user_relationship_status_id AS user_relationship_status_id')->get();
		// user
		$data['user'] = $user;
		
		// Comments
		$comments = DB::table('comments')->join('contents', 'comments.content_id', '=', 'contents.id')->join('users', 'comments.user_id', '=', 'users.id')->where('contents.content_type_id', 3)->where('comments.is_approved', 1)->orderBy('comments.created_at', 'asc')->select('comments.id AS id', 'comments.comment AS comment', 'comments.created_at AS created_at', 'comments.content_id AS content_id', 'comments.user_id AS user_id', 'users.username AS username', 'users.username_slug AS username_slug', 'users.user_profile_picture AS user_profile_picture');
		$data['comments_count'] = count($comments->get());
		$data['comments'] = $comments->get();
		
		/* pass header variables to view */
		$data['contents_count'] = count($contents->get());
		$data['contents'] = $contents->paginate(5);
		$data['heading'] = $user->username . " User Profile";
		
        return view('user.profile_card', $data)->nest('content', 'layouts.content', $data);
    }
	// View user associate list
	public function associatesList(User $user) {
		$data['user'] = $user;
		// Associate relationship stuff
		$data['user_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '!=', 4)->select('relationships.id AS id', 'associators.id AS associator_id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.id AS associated_id', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'relationships.user_relationship_status_id AS user_relationship_status_id', 'relationships.initiated_by_id AS initiated_by_id', 'relationships.accepted_by_id AS accepted_by_id')->get();
		$data['pending_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->where('relationships.user_relationship_status_id', 1)->where('associated_id', $user->id)->select('relationships.id AS id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug')->get();
		$data['pending_delete_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS initiators', 'relationships.initiated_by_id', '=', 'initiators.id')->where('relationships.user_relationship_status_id', 3)->where('associated_id', $user->id)->select('relationships.id AS id', 'relationships.initiated_by_id AS initiator_id', 'initiators.username AS initiator_name', 'initiators.username_slug AS initiator_username_slug')->get();
		$data['relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '=', 2)->select('relationships.id AS id', 'associators.id AS associator_id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associators.user_profile_picture AS associator_profile_picture', 'associateds.id AS associated_id', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'associateds.user_profile_picture AS associated_profile_picture', 'relationships.user_relationship_status_id AS user_relationship_status_id')->get();
		// heading
		$data['heading'] = $user->username . "'s Associates List";
		
		return view('user.profile_card', $data)->nest('user_associates', 'user.associates', $data);
	}
	// View user Checklist
	public function userChecklist(User $user)
    {
		$data['user'] = $user;
		$contents = DB::table('contents')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->join('content_user_favourites', 'contents.id', '=', 'content_user_favourites.content_id')->join('creative_contents', 'contents.id', '=', 'creative_contents.content_id')->join('creative_content_types', 'creative_contents.creative_content_type_id', '=', 'creative_content_types.id')->where('content_user_favourites.user_id', '=', $user->id)->where('contents.is_draft', 0)->where('contents.is_approved', 1)->where('contents.is_published', 1)->whereNull('content_user_favourites.deleted_at')->orderBy('contents.created_at', 'desc');
		// Associate relationship stuff
		$data['user_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '!=', 4)->select('relationships.id AS id', 'associators.id AS associator_id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.id AS associated_id', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'relationships.user_relationship_status_id AS user_relationship_status_id', 'relationships.initiated_by_id AS initiated_by_id', 'relationships.accepted_by_id AS accepted_by_id')->get();
		$data['pending_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->where('relationships.user_relationship_status_id', 1)->where('associated_id', $user->id)->select('relationships.id AS id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug')->get();
		$data['pending_delete_relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS initiators', 'relationships.initiated_by_id', '=', 'initiators.id')->where('relationships.user_relationship_status_id', 3)->where('associated_id', $user->id)->select('relationships.id AS id', 'relationships.initiated_by_id AS initiator_id', 'initiators.username AS initiator_name', 'initiators.username_slug AS initiator_username_slug')->get();
		$data['relationships'] = DB::table('user_relationships AS relationships')->leftJoin('users AS associators', 'relationships.associator_id', '=', 'associators.id')->leftJoin('users AS associateds', 'relationships.associated_id', '=', 'associateds.id')->orWhere(function($query) use ($user) {
			$query->where('relationships.associator_id', '=', $user->id)->orWhere('relationships.associated_id', '=', $user->id);
		})->where('relationships.user_relationship_status_id', '=', 2)->select('relationships.id AS id', 'associators.id AS associator_id', 'associators.username AS associator_name', 'associators.username_slug AS associator_username_slug', 'associateds.id AS associated_id', 'associateds.username AS associated_name', 'associateds.username_slug AS associated_username_slug', 'relationships.user_relationship_status_id AS user_relationship_status_id')->get();
		
		/* Get publish number */
		/* get unique creation dates */
		$date_created = Content::where('content_type_id', 6)->pluck('created_at');
		$date_only = array();
		foreach ($date_created as $date_and_time) {
			$date_only[] = str_limit($date_and_time, 10);
		}
		$publishes = count(array_unique($date_only));
		
		/* count number of headlines */
		$headlines_count = HeadlinesContent::all()->count();
		
		/* check last updated */
		$last_updated = Content::where('content_type_id', 6)->orderBy('id', 'desc')->first();
		
		// get random Zambian fact
		$random_fact = FactsContent::all()->random(1);
		$data['facts_content'] = Content::find($random_fact->content_id);
		
		/* pass variables to view */
		$data['contents_count'] = count($contents->get());
		$data['contents'] = $contents->paginate(5);
		$data['heading'] = $user->username . "'s Checklist";
		
        return view('user.profile_card', $data)->nest('content', 'layouts.content', $data);
    }
	// View user profile edit page
	public function editUserProfile(User $user)
    {
		// check if logged in user same as profile page owner
		$profile_user = $user;
		if ($profile_user->id != auth()->user()->id) {
			abort(404);
		}
		// User type specifics
		if ($user->user_type_id == 1) {
			$data['user_type'] = DB::table('company_users')->leftJoin('company_user_specifics', 'company_users.company_user_specific_id', '=', 'company_user_specifics.id')->where('company_users.user_id', $user->id)->first();
		} elseif ($user->user_type_id == 2) {
			$data['user_type'] = DB::table('group_users')->leftJoin('group_user_specifics', 'group_users.group_user_specific_id', '=', 'group_user_specifics.id')->where('group_users.user_id', $user->id)->first();
		} elseif ($user->user_type_id == 3) {
			$data['user_type'] = DB::table('individual_users')->leftJoin('individual_user_specifics', 'individual_users.individual_user_specific_id', '=', 'individual_user_specifics.id')->where('individual_users.user_id', $user->id)->first();
		}
		// Company specifics
		$company_specifics = CompanyUserSpecific::orderBy('company_user_specific', 'asc')->pluck('company_user_specific');
		$company_specifics->toJson();
		$data['company_specifics'] = $company_specifics;
		// Group specifics
		$group_specifics = GroupUserSpecific::orderBy('group_user_specific', 'asc')->pluck('group_user_specific');
		$group_specifics->toJson();
		$data['group_specifics'] = $group_specifics;
		// Individual specifics
		$individual_specifics = IndividualUserSpecific::orderBy('individual_user_specific', 'asc')->pluck('individual_user_specific');
		$individual_specifics->toJson();
		$data['individual_specifics'] = $individual_specifics;
		// Country, Provinces and Districts
		$data['areas'] = Area::orderBy('area_name', 'asc')->get();
		$data['countries'] = Country::orderBy('country', 'asc')->get();
		$data['provinces'] = Province::orderBy('province', 'asc')->get();
		$data['districts'] = District::orderBy('district', 'asc')->get();
		// User location
		$data['user_location'] = DB::table('locations')->leftJoin('areas', 'locations.area_id', '=', 'areas.id')->leftJoin('districts', 'locations.district_id', '=', 'districts.id')->leftJoin('provinces', 'locations.province_id', '=', 'provinces.id')->leftJoin('countries', 'locations.country_id', '=', 'countries.id')->where('locations.id', $user->location_id)->select('locations.id AS id', 'locations.area_id AS area_id', 'areas.area_name AS area_name', 'locations.district_id AS district_id', 'districts.district AS district', 'locations.province_id AS province_id', 'provinces.province AS province', 'locations.country_id AS country_id', 'countries.country AS country')->first();
		// user info
		$data['user'] = $user;
		// Use mobile
		$data['user_mobile'] = UserMobile::whereUserId($user->id)->first();
		$data['heading'] = "Edit " . $user->username . " Profile";
		
        return view('user.edit', $data)->nest('user_profile_card', 'user.profile_card', $data);
    }
	// update user profile information
	public function updateUserProfile(Requested $request, User $user)
    {
		// check if logged in user same as profile page owner
		$profile_user = $user;
		if ($profile_user->id != auth()->user()->id) {
			abort(404);
		}
		if ($profile_user->username == $request->username) {
			$request['username'] = $request->username . '1';
		}
		if ($request->day_established && $request->month_established && $request->year_established) {
			$request['date_established'] = $request->day_established.'-'.$request->month_established.'-'.$request->year_established;
		}
		if ($request->day_formed && $request->month_formed && $request->year_formed) {
			$request['date_formed'] = $request->day_formed.'-'.$request->month_formed.'-'.$request->year_formed;
		}
		if (isset($request->day_of_birth) && isset($request->month_of_birth) && isset($request->year_of_birth)) {
			$request['date_of_birth'] = $request->day_of_birth.'-'.$request->month_of_birth.'-'.$request->year_of_birth;
		}
		$day = array('regex:/^((0[1-9])|(1[0-9])|(2[0-9])|(3[0-1]))$/');
		$month = array('regex:/^((0[1-9])|(1[0-2]))$/');
		$year = array('regex:/^((18\d{2}$)|(19\d{2})|(200[0-9])|(201[0-6]))$/');
		$other = array('required_if:mobile_network,Other','regex:/^(((?!095)\d{10})|((?!096)\d{10})|((?!097)\d{10}))$/');
		// validate required fields
		$this->validate($request, [
			'username' => 'required|unique:users',
			'day_established' => $day,
			'month_established' => $month,
			'year_established' => $year,
			'day_formed' => $day,
			'month_formed' => $month,
			'year_formed' => $year,
			'day_of_birth' => $day,
			'month_of_birth' => $month,
			'year_of_birth' => $year,
			'date_established' => 'date_format:d-m-Y',
			'date_formed' => 'date_format:d-m-Y',
			'date_of_birth' => 'date_format:d-m-Y',
			'password' => 'required|same:password_confirm|min:6',
			'password_confirm' => 'required',
			'MobileNetwork' => 'required_with:Number',
			'Airtel' => 'required_if:mobile_network,Airtel|regex:(^097\d{7}$)',
			'MTN' => 'required_if:mobile_network,MTN|regex:(^096\d{7}$)',
			'Zamtel' => 'required_if:mobile_network,Zamtel|regex:(^095\d{7}$)',
			'Other' => $other,
			'email' => 'required|email',
		]);
		// Fetch user profile information
		$profile = User::find($user->id);
		if (!($profile_user->username.'1' == $request->username)) {
			$profile->username = $request->username;
			$profile->username_slug = Str::slug($request->username, "");
		}
		// Company specific
		if ($user->user_type_id == 1) {
			$company = CompanyUser::whereUserId($user->id)->first();
			$company_user_specifics = CompanyUserSpecific::orderBy('company_user_specific', 'asc')->select('company_user_specific')->get();
			$company_user_specifics_array = array();
			foreach ($company_user_specifics as $company_user_specific) {
				$company_user_specifics_array[] = $company_user_specific->company_user_specific;
			}
			if (in_array($request->company_specialisation, $company_user_specifics_array)) {
				$select_company_user_specific = CompanyUserSpecific::where('company_user_specific', $request->company_specialisation)->first();
				$company->company_user_specific_id = $select_company_user_specific->id;
			} else {
				if ($request->company_specialisation != "") {
					$new_company_user_specific = new CompanyUserSpecific;
					$new_company_user_specific->company_user_specific = $request->company_specialisation;
					$new_company_user_specific->created_by = $user->id;
					$new_company_user_specific->save();
					$company->company_user_specific_id = $new_company_user_specific->id;
				}
			}
			$company->dateEstablished = $request->year_established.'-'.$request->month_established.'-'.$request->day_established;
			$company->save();
		}
		// Group specific
		if ($user->user_type_id == 2) {
			$group = GroupUser::whereUserId($user->id)->first();
			$group_user_specifics = GroupUserSpecific::orderBy('group_user_specific', 'asc')->select('group_user_specific')->get();
			$group_user_specifics_array = array();
			foreach ($group_user_specifics as $group_user_specific) {
				$group_user_specifics_array[] = $group_user_specific->group_user_specific;
			}
			if (in_array($request->group_type, $group_user_specifics_array)) {
				$select_group_user_specific = GroupUserSpecific::where('group_user_specific', $request->group_type)->first();
				$group->group_user_specific_id = $select_group_user_specific->id;
			} else {
				if ($request->group_type != "") {
					$new_group_user_specific = new GroupUserSpecific;
					$new_group_user_specific->group_user_specific = $request->group_type;
					$new_group_user_specific->created_by = $user->id;
					$new_group_user_specific->save();
					$group->group_user_specific_id = $new_group_user_specific->id;
				}
			}
			$group->established = $request->year_formed.'-'.$request->month_formed.'-'.$request->day_formed;
			$group->group_members = $request->group_members;
			$group->save();
		}
		// Individual specific
		if ($user->user_type_id == 3) {
			$individual = IndividualUser::whereUserId($user->id)->first();
			$individual->gender_id = $request->gender;
			$individual_user_specifics = IndividualUserSpecific::orderBy('individual_user_specific', 'asc')->select('individual_user_specific')->get();
			$individual_user_specifics_array = array();
			foreach ($individual_user_specifics as $individual_user_specific) {
				$individual_user_specifics_array[] = $individual_user_specific->individual_user_specific;
			}
			if (in_array($request->occupation, $individual_user_specifics_array)) {
				$select_individual_user_specific = IndividualUserSpecific::where('individual_user_specific', $request->occupation)->first();
				$individual->individual_user_specific_id = $select_individual_user_specific->id;
			} else {
				if ($request->occupation != "") {
					$new_individual_user_specific = new IndividualUserSpecific;
					$new_individual_user_specific->individual_user_specific = $request->occupation;
					$new_individual_user_specific->created_by = $user->id;
					$new_individual_user_specific->save();
					$individual->individual_user_specific_id = $new_individual_user_specific->id;
				}
			}
			$individual->date_of_birth = $request->year_of_birth.'-'.$request->month_of_birth.'-'.$request->day_of_birth;
			$individual->save();
		}
		// user profile picture
		if (Request::has('profile_picture_link')) {
			if (!($profile->user_profile_picture == $request->profile_picture_link)) {
				if (str_contains($request->profile_picture_link, 'oneziko.com/public')) {
					$profile->user_profile_picture = $request->profile_picture_link;
				} else {
					$image_url = Str::replace('"', "'", $request->profile_picture_link);
					$filename  = basename($image_url);
					$path = public_path('images/users/' . $filename);
					$image = Image::make($image_url)->save($path);
					$profile->user_profile_picture = url('public/images/users/' . $filename);
				}
			}
		}
		if (Request::hasFile('profile_picture_upload')) {
			$file = $request->file('profile_picture_upload');
			$file_ext = Str::replace('image/', '', $file->getMimeType());
			$filename  = $user->id . '-' . date("dmY-His.") . $file_ext;
			$path = public_path('images/users/' . $filename);
			$image = Image::make($file->getRealPath())->save($path);
			$profile->user_profile_picture = url('public/images/users/' . $filename);
		}
		if (!Hash::check($request->password, $profile_user->password)) {
			if ($request->password != $profile_user->password) {
				$profile->password = \Hash::make($request->password);
			}
		}
		// User mobile
		$user_mobile = UserMobile::where('user_id', '=', $user->id)->first();
		// Set user mobile network
		if ($request->mobile_network == "Airtel") {
			$user_mobile->mobile_service_provider_id = 1;
		} elseif ($request->mobile_network == "MTN") {
			$user_mobile->mobile_service_provider_id = 2;
		} elseif ($request->mobile_network == "Zamtel") {
			$user_mobile->mobile_service_provider_id = 3;
		} elseif ($request->mobile_network == "Other") {
			$user_mobile->mobile_service_provider_id = 4;
		}
		// Set user mobile number
		if (!is_null($request->Airtel)) {
			$user_mobile->user_mobile_number = $request->Airtel;
		} elseif (!is_null($request->MTN)) {
			$user_mobile->user_mobile_number = $request->MTN;
		} elseif (!is_null($request->Zamtel)) {
			$user_mobile->user_mobile_number = $request->Zamtel;
		} elseif (!is_null($request->Other)) {
			$user_mobile->user_mobile_number = $request->Other;
		}
		$user_mobile->save();
		$profile->email = $request->email;
		$profile->website = $request->website;
		// Get Location
		$location = Location::whereCountryId($request->country)->whereProvinceId($request->province)->whereDistrictId($request->district)->whereAreaId($request->area)->first();
		if (!is_null($location)) {
			$profile->location_id = $location->id;
		} else {
			if (!is_null($request->area) || !is_null($request->district) || !is_null($request->province) || !is_null($request->country)) {
				$new_location = new Location;
				$new_location->area_id = $new_location->district_id = $new_location->province_id = $new_location->country_id = 0;
				if (!is_null($request->area))
					$new_location->area_id = $request->area;
				if (!is_null($request->district))
					$new_location->district_id = $request->district;
				if (!is_null($request->province))
					$new_location->province_id = $request->province;
				if (!is_null($request->country))
					$new_location->country_id = $request->country;
				$new_location->created_by = $user->id;
				$new_location->save();
				$profile->location_id = $new_location->id;
			}
		}
		$profile->slogan = $request->slogan;
		$profile->about = $request->about;
		$profile->save();
		
        return redirect(route('edit-user-profile', $profile->username_slug));
    }
	// View / Edit user preferences
	public function editUserPreferences(User $user)
    {
		// check if logged in user same as profile page owner
		$data['user'] = $user;
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		// 
		$user_headline_source_preference = UserHeadlineSourcePreference::whereUserId($user->id)->first();
		
		/* get unique creation dates */
		$date_created = Content::where('content_type_id', 7)->pluck('created_at');
		$date_only = array();
		foreach ($date_created as $date_and_time) {
			$date_only[] = str_limit($date_and_time, 10);
		}
		$publishes = count(array_unique($date_only));
		
		/* count number of headlines */
		$headlines_count = HeadlinesContent::all()->count();
		
		/* check last updated */
		$last_updated = Content::where('content_type_id', 7)->orderBy('id', 'desc')->first();
		
		/* pass variables to view */
		$data['publishes'] = $publishes;
		$data['headlines_count'] = $headlines_count;
		$data['last_updated'] = $last_updated;
		$data['user_headline_source_preference'] = $user_headline_source_preference;
		
        return view('user.preferences', $data)->nest('user_profile_preferences', 'user.profile_card', $data);;
    }
	public function sendEmail(Request $request, $id)
	{
		$user = User::findOrFail($id);

		Mail::send('emails.reminder', ['user' => $user], function ($message) use ($user) {
			$message->from('info@oneziko.com', 'Your Application');

			$message->to($user->email, $user->name)->subject('Test eMail!');
		});
	}
}
