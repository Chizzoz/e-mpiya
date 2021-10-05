<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ContentUserRating extends Model {

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
