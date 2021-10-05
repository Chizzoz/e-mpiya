<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class InContentAd extends Eloquent {

	protected $fillable = [];
	
	public function content()
	{
		return $this->belongsTo('Content');
	}

}