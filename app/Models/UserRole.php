<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserRole extends Eloquent {

	protected $fillable = [];
	
	public function userAccesses()
	{
		return $this->hasMany('UserAccess');
	}

}