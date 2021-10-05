<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeadlinesContent extends Model {

	protected $fillable = ['content_id',
                           'publish_date',
                           'publisher_name',
                           'publisher_url'];
	
	public $timestamps = false;
	
	public function content()
	{
		return $this->belongsTo('Content');
	}

}
