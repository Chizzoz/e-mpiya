<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentType extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContents()
	{
		return $this->hasMany('MaliketiContent');
	}
	
	public function maliketiContentSubTypes()
	{
		return $this->hasMany('MaliketiContentSubType');
	}

}