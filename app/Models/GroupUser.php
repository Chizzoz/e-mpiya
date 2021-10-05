<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GroupUser extends Eloquent {

	protected $fillable = [];
	
	public function groupUserSpecific()
	{
		return $this->belongsTo('GroupUserSpecific');
	}
	
	public function user()
	{
		return $this->belongsTo('User');
	}

}