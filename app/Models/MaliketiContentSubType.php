<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentSubType extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContents()
	{
		return $this->hasMany('MaliketiContent');
	}
	
	public function maliketiContentType()
	{
		return $this->belongsTo('MaliketiContentType');
	}

}