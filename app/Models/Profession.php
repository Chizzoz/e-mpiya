<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Profession extends Eloquent {

	//protected $fillable = [];
	
	public function userProfessions()
	{
		return $this->hasMany('UserProfession');
	}
	
	public function maliketiContentProfessions()
	{
		return $this->hasMany('MaliketiContentProfession');
	}

}