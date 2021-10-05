<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentSoftware extends Eloquent {

	protected $fillable = [];
	
	public function software()
	{
		return $this->belongsTo('Software');
	}
	
	public function creativeContent()
	{
		return $this->belongsTo('CreativeContent');
	}

}