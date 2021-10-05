<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentRealEstate extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContent()
	{
		return $this->belongsTo('MaliketiContent');
	}
	
	public function bedroom()
	{
		return $this->belongsTo('Bedroom');
	}

}