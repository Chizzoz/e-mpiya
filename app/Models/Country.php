<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Country extends Eloquent {

	protected $fillable = [];
	
	public function locations()
	{
		return $this->hasMany('App\Models\Location');
	}
	
	public function provinces()
	{
		return $this->hasMany('App\Models\Province');
	}

}