<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentArticle extends Eloquent {

	protected $fillable = [];
	
	public function creativeContent()
	{
		return $this->belongsTo('CreativeContent');
	}

}