<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class District extends Eloquent {

	protected $fillable = [];
	
	public function locations()
	{
		return $this->hasMany('Location');
	}
	
	public function province()
	{
		return $this->belongsTo('Province');
	}
	
	public function areas()
	{
		return $this->hasMany('Area');
	}

}