<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model {

	protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function userRole()
	{
		return $this->belongsTo('UserRole');
	}

}
