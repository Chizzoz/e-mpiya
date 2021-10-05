<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserType extends Eloquent {

	protected $fillable = [];
	
	public function users()
	{
		return $this->hasMany('User');
	}

}