<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Software extends Eloquent {

	protected $fillable = [];
	
	public function creativeContentSoftwares()
	{
		return $this->hasMany('CreativeContent');
	}
	
	public function softwareSubs()
	{
		return $this->hasMany('SoftwareSub');
	}

}