<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;

class SocialAuthController extends Controller
{
	/**
	 * Redirect the user to the Provider authentication page.
	 *
	 * @return Response
	 */
	public function redirect($provider)
	{
		return Socialite::driver($provider)->redirect();    
	}
	/**
	 * Obtain the user information from Provider.
	 *
	 * @return Response
	 */
	public function callback($provider)
	{
		// when facebook call us a with token   
	}
}
