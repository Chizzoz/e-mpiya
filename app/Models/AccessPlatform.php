<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessPlatform extends Model {

	protected $fillable = [];
	
	public function contents()
	{
		return $this->hasMany('content');
	}

}