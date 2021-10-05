<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeIndustrySub extends Eloquent {

	protected $fillable = [];
	
	public function creativeContentIndustrySubs()
	{
		return $this->hasMany('CreativeContentIndustrySub');
	}
	
	public function userCreativeIndustrySubs()
	{
		return $this->hasMany('UserCreativeIndustrySub');
	}
	
	public function creativeIndustry()
	{
		return $this->belongsTo('CreativeIndustry');
	}

}