<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserMobile extends Eloquent {

	protected $fillable = [];
	
	public function mobileServiceProvider()
	{
		return $this->belongsTo('MobileServiceProvider');
	}
	
	public function user()
	{
		return $this->hasOne('User');
	}

}