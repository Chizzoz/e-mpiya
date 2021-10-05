<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ContentType extends Eloquent {

	protected $fillable = [];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'content_type_slug';
	}
	
	public function contents()
	{
		return $this->hasMany('Content');
	}

}