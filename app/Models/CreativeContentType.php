<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContentType extends Eloquent {

	protected $fillable = [];
	
	public function creativeContents()
	{
		return $this->hasMany('CreativeContent');
	}

}