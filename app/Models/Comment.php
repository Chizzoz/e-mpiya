<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Comment extends Eloquent {

	protected $fillable = [];
	
	public function content()
	{
		return $this->belongsTo('Content');
	}
	
	public function user()
	{
		return $this->belongsTo('User');
	}

}