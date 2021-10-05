<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Province extends Eloquent {

	protected $fillable = [];
	
	public function districts()
	{
		return $this->hasMany('District');
	}
	
	public function locations()
	{
		return $this->hasMany('Location');
	}
	
	public function country()
	{
		return $this->belongsTo('Country');
	}

}