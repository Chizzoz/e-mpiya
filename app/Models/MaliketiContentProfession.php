<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentProfession extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContent()
	{
		return $this->belongsTo('MaliketiContent');
	}
	
	public function profession()
	{
		return $this->belongsTo('Profession');
	}

}