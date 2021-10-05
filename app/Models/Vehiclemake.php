<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class VehicleMake extends Eloquent {

	protected $fillable = [];
	
	public function vehicleModels()
	{
		return $this->hasMany('VehicleModel');
	}
	
	public function maliketiContentVehicles()
	{
		return $this->hasMany('MaliketiContentVehicles');
	}

}