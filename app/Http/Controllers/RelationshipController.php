<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\UserRelationship;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;

class RelationshipController extends Controller
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
	
	// Request association
	public function requestAssociation(User $associated, User $associator)
	{
		$user_relationship = new UserRelationship;
		$user_relationship->associator_id = $associator->id;
		$user_relationship->associated_id = $associated->id;
		$user_relationship->user_relationship_status_id = 1;
		$user_relationship->save();
		// Send request association email
		$data['associator'] = $associator;
		$data['associated'] = $associated;
		Mail::send('emails.association_request', $data, function ($message) use ($associated) {
			$message->from('info@oneziko.com', 'One Ziko Info');
			$message->to($associated->email, $associated->username)->subject('Pending Association Request');
		});
		
		return back()->withInput();
	}
	
	// Accept association request
	public function acceptAssociationRequest(UserRelationship $user_relationship)
	{
		$user_relationship = UserRelationship::whereId($user_relationship->id)->first();
		$user_relationship->user_relationship_status_id = 2;
		$user_relationship->save();
		// Send request association email
		$associator = User::find($user_relationship->associator_id);
		$data['associator'] = $associator;
		$data['associated'] = User::find($user_relationship->associated_id);
		Mail::send('emails.association_accepted', $data, function ($message) use ($associator) {
			$message->from('info@oneziko.com', 'One Ziko Info');
			$message->to($associator->email, $associator->username)->subject('Accepted Association Request');
		});
		
		return back()->withInput();
	}
	
	// Delete association
	public function deleteAssociationRequest(User $user, UserRelationship $user_relationship)
	{
		$user_relationship = UserRelationship::whereId($user_relationship->id)->first();
		$user_relationship->user_relationship_status_id = 3;
		$user_relationship->initiated_by_id = $user->id;
		$user_relationship->save();
		// Send delete association request email
		$requestor = User::find($user_relationship->initiated_by_id);
		if ($requestor->id == $user_relationship->associator_id) {
			$acceptor = User::find($user_relationship->associated_id);
		} else {
			$acceptor = User::find($user_relationship->associator_id);
		}
		$data['acceptor'] = $acceptor;
		$data['requestor'] = $requestor;
		Mail::send('emails.association_delete_request', $data, function ($message) use ($acceptor) {
			$message->from('info@oneziko.com', 'One Ziko Info');
			$message->to($acceptor->email, $acceptor->username)->subject('Accepted Association Request');
		});
		
		return back()->withInput();
	}
	
	// Cancel pending delete association
	public function cancelDeleteAssociationRequest(User $user, UserRelationship $user_relationship)
	{
		$user_relationship = UserRelationship::whereId($user_relationship->id)->first();
		$user_relationship->user_relationship_status_id = 2;
		$user_relationship->initiated_by_id = $user->id;
		$user_relationship->save();
		
		return back()->withInput();
	}
	
	// Accept delete association request
	public function acceptDeleteAssociationRequest(User $user, UserRelationship $user_relationship)
	{
		$user_relationship = UserRelationship::whereId($user_relationship->id)->first();
		$user_relationship->user_relationship_status_id = 4;
		$user_relationship->accepted_by_id = $user->id;
		$user_relationship->save();
		// Send accepted delete association request email
		$requestor = User::find($user_relationship->initiated_by_id);
		if ($requestor->id == $user_relationship->associator_id) {
			$acceptor = User::find($user_relationship->associated_id);
		} else {
			$acceptor = User::find($user_relationship->associator_id);
		}
		$data['acceptor'] = $acceptor;
		$data['requestor'] = $requestor;
		Mail::send('emails.association_delete_request_accepted', $data, function ($message) use ($requestor) {
			$message->from('info@oneziko.com', 'One Ziko Info');
			$message->to($requestor->email, $requestor->username)->subject('Accepted Delete Association Request');
		});
		
		return back()->withInput();
	}
	
	// Accept association
	public function acceptPendingAssociationRequest(User $user, UserRelationship $user_relationship)
	{
		$user_relationship = UserRelationship::where('id', $user_relationship->id)->first();
		$user_relationship->user_relationship_status_id = 2;
		$user_relationship->accepted_by_id = $user->id;
		$user_relationship->save();
		// Send request association email
		$associator = User::find($user_relationship->associator_id);
		$data['associator'] = $associator;
		$data['associated'] = User::find($user_relationship->associated_id);
		Mail::send('emails.association_accepted', $data, function ($message) use ($associator) {
			$message->from('info@oneziko.com', 'One Ziko Info');
			$message->to($associator->email, $associator->username)->subject('Accepted Association Request');
		});
		
		return back()->withInput();
	}
	
	// Delete pending association
	public function deletePendingAssociationRequest(User $user, UserRelationship $user_relationship)
	{
		$user_relationship = UserRelationship::where('id', $user_relationship->id)->first();
		$user_relationship->user_relationship_status_id = 4;
		$user_relationship->initiated_by_id = $user->id;
		$user_relationship->save();
		
		return back()->withInput();
	}
}
