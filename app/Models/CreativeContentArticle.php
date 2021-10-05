<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentArticle extends Eloquent {

	protected $fillable = [];
	
	public function creativeContent()
	{
		return $this->belongsTo('CreativeContent');
	}

}