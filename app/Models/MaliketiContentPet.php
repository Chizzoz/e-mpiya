<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentPet extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContent()
	{
		return $this->belongsTo('MaliketiContent');
	}

}