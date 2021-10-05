<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class IndividualUserSpecific extends Eloquent {

	protected $fillable = [];
	
	public function individualUsers()
	{
		return $this->hasMany('IndividualUser');
	}

}