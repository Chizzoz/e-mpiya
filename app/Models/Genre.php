<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model {

	protected $fillable = [];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'genre_slug';
	}
	
	public function lyricsContents()
	{
		return $this->hasMany('LyricsContent');
	}

}
