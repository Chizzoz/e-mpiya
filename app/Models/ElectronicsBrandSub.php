<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ElectronicsBrandSub extends Eloquent {

	protected $fillable = [];
	
	public function electronicsBrand()
	{
		return $this->belongsTo('ElectronicsBrand');
	}
	
	public function maliketiContentElectronics()
	{
		return $this->hasMany('MaliketiContentElectronic');
	}

}