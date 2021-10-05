<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class GroupUserSpecific extends Eloquent {

	protected $fillable = [];
	
	public function groupUsers()
	{
		return $this->hasMany('GroupUser');
	}

}