<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model {

	protected $fillable = [];
	
	public function individualUser()
	{
		return $this->belongsTo('IndividualUser');
	}
	
	public function language()
	{
		return $this->belongsTo('Language');
	}

}
