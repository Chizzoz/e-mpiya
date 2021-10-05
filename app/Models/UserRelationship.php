<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserRelationship extends Model {

	protected $fillable = [];
	
	public function userRelationshipStatus()
	{
		return $this->belongsTo('App\Models\UserRelationshipStatus');
	}
	
	public function associator()
	{
		return $this->belongsTo('App\Models\User', 'associator_id');
	}
	
	public function associated()
	{
		return $this->belongsTo('App\Models\User', 'associated_id');
	}
	
	public function content()
	{
		return $this->belongsTo('App\Models\Content');
	}

}
