<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class SoftwareSub extends Eloquent {

	protected $fillable = [];
	
	public function creativeContentSoftwareSubs()
	{
		return $this->hasMany('CreativeContentSoftwareSub');
	}
	
	public function software()
	{
		return $this->belongsTo('Software');
	}

}