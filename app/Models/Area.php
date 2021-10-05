<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Area extends Eloquent {

	protected $fillable = [];
	
	public function location()
	{
		return $this->hasOne('Location');
	}
	
	public function district()
	{
		return $this->belongsTo('District');
	}

}