<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class AccessPlatform extends Model {

	protected $fillable = [];
	
	public function contents()
	{
		return $this->hasMany('content');
	}

}