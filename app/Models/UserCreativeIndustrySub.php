<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserCreativeIndustrySub extends Eloquent {

	protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function creativeIndustrySub()
	{
		return $this->belongsTo('CreativeIndustrySub');
	}

}