<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class IndividualUser extends Eloquent {

	protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function individualUserSpecific()
	{
		return $this->belongsTo('IndividualUserSpecific');
	}
	
	public function userLanguages()
	{
		return $this->hasMany('UserLanguage');
	}
	
	public function gender()
	{
		return $this->belongsTo('Gender');
	}

}