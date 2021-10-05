<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentStatus extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContents()
	{
		return $this->hasMany('MaliketiContent');
	}

}