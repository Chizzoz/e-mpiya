<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Location extends Eloquent {

	protected $fillable = [];
	
	public function country()
	{
		return $this->belongsTo('Country');
	}
	
	public function district()
	{
		return $this->belongsTo('District');
	}
	
	public function province()
	{
		return $this->belongsTo('Province');
	}
	
	public function area()
	{
		return $this->belongsTo('Area');
	}
	
	public function contents()
	{
		return $this->hasMany('Content');
	}
	
	public function users()
	{
		return $this->hasMany('User');
	}

}