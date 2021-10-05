<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class ElectronicsBrand extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContentElectronics()
	{
		return $this->hasMany('MaliketiContentElectronic');
	}
	
	public function electronicsBrandSubs()
	{
		return $this->hasMany('ElectronicsBrandSub');
	}

}