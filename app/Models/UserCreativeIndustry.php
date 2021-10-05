<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserCreativeIndustry extends Eloquent {

	protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function creativeIndustry()
	{
		return $this->belongsTo('CreativeIndustry');
	}

}