<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MobileServiceProvider extends Eloquent {

	protected $fillable = [];
	
	public function userMobiles()
	{
		return $this->hasMany('UserMobile');
	}

}