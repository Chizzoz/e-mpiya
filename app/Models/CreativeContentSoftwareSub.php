<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentSoftwareSub extends Eloquent {

	protected $fillable = [];
	
	public function softwareSub()
	{
		return $this->belongsTo('SoftwareSub');
	}
	
	public function creativeContent()
	{
		return $this->belongsTo('CreativeContent');
	}

}