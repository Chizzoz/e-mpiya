<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentIndustry extends Eloquent {

	protected $fillable = [];
	
	public function creativeContent()
	{
		return $this->belongsTo('CreativeContent');
	}
	
	public function creativeIndustry()
	{
		return $this->belongsTo('CreativeIndustry');
	}

}