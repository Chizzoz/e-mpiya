<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class UserProfession extends Eloquent {

	protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function profession()
	{
		return $this->belongsTo('Profession');
	}

}