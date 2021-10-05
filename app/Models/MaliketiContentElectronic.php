<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentElectronic extends Eloquent {

	protected $fillable = [];
	
	public function electronicsBrand()
	{
		return $this->belongsTo('ElectronicsBrand');
	}
	
	public function electronicsBrandSub()
	{
		return $this->belongsTo('ElectronicsBrandSub');
	}
	
	public function maliketiContent()
	{
		return $this->belongsTo('MaliketiContent');
	}

}