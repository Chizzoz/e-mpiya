<?php namespace App\Models;

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