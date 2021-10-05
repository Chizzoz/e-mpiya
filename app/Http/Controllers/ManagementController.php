<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Content;
use App\Models\ContentType;
use App\Models\UserAccess;
use App\Models\User;
use DB;
use Illuminate\Http\Request;


class ManagementController extends Controller
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
	// manage content
	public function manageContent(User $user, ContentType $content_type)
    {
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		// manage creative content
		if ($content_type->id == 1) {
			$data['contents'] = DB::table('contents')->join('creative_contents', 'contents.id', '=', 'creative_contents.content_id')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->where('contents.user_id', $user->id)->orderBy('contents.created_at', 'desc')->get();
			$data['user'] = $user;
			$data['link'] = "timeline-content";
			$content_type = ContentType::find(1);
			$data['heading'] = "Manage " . $content_type->content_type;
		}
		// manage lyrics content
		if ($content_type->id == 3) {
			$data['contents'] = DB::table('contents')->join('lyrics_contents', 'contents.id', '=', 'lyrics_contents.content_id')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->where('contents.user_id', $user->id)->orderBy('contents.created_at', 'desc')->get();
			$data['user'] = $user;
			$data['link'] = "timeline-content";
			$content_type = ContentType::find(3);
			$data['heading'] = "Manage " . $content_type->content_type;
		}
		// manage timeline content
		if ($content_type->id == 5) {
			$data['contents'] = DB::table('contents')->join('timeline_contents', 'contents.id', '=', 'timeline_contents.content_id')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->orderBy('timeline_contents.start_date', 'desc')->get();
			$data['user'] = $user;
			$data['link'] = "timeline-content";
			$content_type = ContentType::find(5);
			$data['heading'] = "Manage " . $content_type->content_type;
		}
		// manage facts content
		if ($content_type->id == 6) {
			$data['contents'] = DB::table('contents')->join('facts_contents', 'contents.id', '=', 'facts_contents.content_id')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->where('contents.user_id', $user->id)->orderBy('contents.created_at', 'desc')->get();
			$data['user'] = $user;
			$data['link'] = "timeline-content";
			$content_type = ContentType::find(6);
			$data['heading'] = "Manage " . $content_type->content_type;
		}
		// manage headline content
		if ($content_type->id == 7) {
			// check admin user rights
			$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($user->id)->orderBy('user_role_id', 'ASC')->first();
			if (!isset($user_admin_access)) {
				abort(404);
			}
			$data['contents'] = DB::table('contents')->join('headlines_contents', 'contents.id', '=', 'headlines_contents.content_id')->join('content_types', 'contents.content_type_id', '=', 'content_types.id')->join('users', 'contents.user_id', '=', 'users.id')->join('access_platforms', 'contents.access_platform_id', '=', 'access_platforms.id')->orderBy('headlines_contents.publish_date', 'desc')->get();
			$data['user'] = $user;
			$data['link'] = "headlines-content";
			$content_type = ContentType::find(7);
			$data['heading'] = "Manage " . $content_type->content_type;
		}
		
        return view('manage.content', $data)->nest('user_profile_card', 'user.profile_card', $data);
    }
	// Approve Content
	public function approveContent(User $user, Content $content)
	{
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		// check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		}
		if ($content->is_approved != 1) {
			$content->is_approved = 1;
			$content->save();
		}
		// get content type
		$content_type = ContentType::find($content->content_type_id);
		
		return redirect(route('manage-content', array($user->username_slug, $content_type->content_type_slug)));
	}
	// UnApprove Content
	public function unapproveContent(User $user, Content $content)
	{
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		// check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		}
		if ($content->is_approved != 0) {
			$content->is_approved = 0;
			$content->save();
		}
		// get content type
		$content_type = ContentType::find($content->content_type_id);
		
		return redirect(route('manage-content', array($user->username_slug, $content_type->content_type_slug)));
	}
	// Publish Content
	public function publishContent(User $user, Content $content)
	{
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		/* check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		} */
		if ($content->is_published != 1) {
			$content->is_published = 1;
			$content->save();
		}
		// get content type
		$content_type = ContentType::find($content->content_type_id);
		
		return redirect(route('manage-content', array($user->username_slug, $content_type->content_type_slug)));
	}
	// Unpublish Content
	public function unpublishContent(User $user, Content $content)
	{
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		/* check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		} */
		if ($content->is_published != 0) {
			$content->is_published = 0;
			$content->save();
		}
		// get content type
		$content_type = ContentType::find($content->content_type_id);
		
		return redirect(route('manage-content', array($user->username_slug, $content_type->content_type_slug)));
	}
	// manage users
	public function manageUsers(User $user)
	{
		// check if logged in user same as profile page owner
		if ($user->id != auth()->user()->id) {
			abort(404);
		}
		// check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		}
		// manage all users
		$data['all_users'] = DB::table('users')->join('user_types', 'users.user_type_id', '=', 'user_types.id')->get();
		// current user
		$profile['user'] = auth()->user();
		$data['heading'] = "Manage Users";
		
		return view('manage.users', $data)->nest('user_profile_card', 'user.profile_card', $profile);
	}
	// activate User
	public function activateUser(User $user)
	{
		$current_user = auth()->user();
		// check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($current_user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		}
		if ($user->is_active != 1) {
			$user->is_active = 1;
			$user->save();
		}
		
		return redirect(route('manage-users', $current_user->username_slug));
	}
	// Deactivate User
	public function deactivateUser(User $user)
	{
		$current_user = auth()->user();
		// check admin user rights
		$user_admin_access = UserAccess::whereUserRoleId(1)->whereUserId($current_user->id)->orderBy('user_role_id', 'ASC')->first();
		if (!isset($user_admin_access)) {
			abort(404);
		}
		if ($user->is_active != 0) {
			$user->is_active = 0;
			$user->save();
		}
		
		return redirect(route('manage-users', $current_user->username_slug));
	}
}
