<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRelationshipStatus extends Model {

	protected $fillable = [];
	
	public function userRelationships()
	{
		return $this->hasMany('UserRelationship');
	}

}
