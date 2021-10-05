<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimelineContent extends Model {

	protected $fillable = [
		'content_id',
		'start_date',
		'end_date',
		'headline',
		'text',
		'media',
		'credit',
		'caption'
	];
	
	public $timestamps = false;
	
	public function content()
	{
		return $this->belongsTo('Content');
	}

}
