<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class LyricsContent extends Model {

	protected $fillable = [];
	
	public function genre()
	{
		return $this->belongsTo('Genre');
	}
	
	public function content()
	{
		return $this->belongsTo('Content');
	}

}
