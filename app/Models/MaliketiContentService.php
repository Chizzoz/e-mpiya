<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentService extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContent()
	{
		return $this->belongsTo('MaliketiContent');
	}

}