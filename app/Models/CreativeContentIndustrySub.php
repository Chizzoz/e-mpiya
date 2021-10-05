<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentIndustrySub extends Eloquent {

	protected $fillable = [];
	
	public function creativeContent()
	{
		return $this->belongsTo('CreativeContent');
	}
	
	public function creativeIndustrySub()
	{
		return $this->belongsTo('CreativeIndustrySub');
	}

}