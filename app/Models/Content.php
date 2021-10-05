<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Content extends Eloquent {

	protected $fillable = [
		'content_type_id',
		'title',
		'user_id',
		'access_platform_id',
		'body',
		'image',
		'link',
		'location_id',
		'is_draft',
		'is_published',
		'title_slug'
	];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'title_slug';
	}
	
	public function accessPlatform()
	{
		return $this->belongsTo('AccessPlatform');
	}
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function creativeContent()
	{
		return $this->hasOne('CreativeContent');
	}
	
	public function location()
	{
		return $this->belongsTo('Location');
	}
	
	public function contentType()
	{
		return $this->belongsTo('ContentType');
	}
	
	public function comments()
	{
		return $this->hasMany('Comment');
	}
	
	public function inContentAd()
	{
		return $this->hasOne('InContentAd');
	}
	
	public function factsContent()
	{
		return $this->hasOne('FactsContent');
	}
	
	public function headlinesContent()
	{
		return $this->hasOne('HeadlinesContent');
	}
	
	public function maliketiContent()
	{
		return $this->hasOne('MaliketiContent');
	}
	
	public function contentUserFavourites()
	{
		return $this->hasMany('ContentUserFavourite');
	}
	
	public function contentUserRatings()
	{
		return $this->hasMany('ContentUserRating');
	}
	
	public function lyricsContent()
	{
		return $this->hasOne('LyricsContent');
	}
	
	public function timelineContent()
	{
		return $this->hasOne('TimelineContent');
	}

}