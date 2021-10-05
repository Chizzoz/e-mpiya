<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Content;
use App\Models\ContentUserFavourite;
use DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request as Requested;

class CheckController extends Controller
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
	
	public function isCheckedByMe($id)
	{
		$content = Content::findOrFail($id)->first();
		if (ContentUserFavourite::whereUserId(Auth::id())->whereContentId($content->id)->exists()){
			return 'true';
		}
		return 'false';
	}
	
	public function check(Requested $request)
	{
		$existing_check = ContentUserFavourite::withTrashed()->whereContentId($request->id)->whereUserId(auth()->user()->id)->first();

		if (is_null($existing_check)) {
			ContentUserFavourite::create([
				'content_id' => $request->id,
				'user_id' => auth()->user()->id,
				'favourite' => 1
			]);
		} else {
			if (is_null($existing_check->deleted_at)) {
				$existing_check->delete();
			} else {
				$existing_check->restore();
			}
		}
	}
}
