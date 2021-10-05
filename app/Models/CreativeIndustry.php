<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeIndustry extends Eloquent {

	protected $fillable = [];
	
	public function creativeContentIndustries()
	{
		return $this->hasMany('CreativeContentIndustry');
	}
	
	public function creativeIndustrySubs()
	{
		return $this->hasMany('CreativeIndustrySub');
	}
	
	public function userCreativeIndustries()
	{
		return $this->hasMany('UserCreativeIndustry');
	}

}