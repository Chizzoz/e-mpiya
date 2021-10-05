<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class VehicleModel extends Eloquent {

	protected $fillable = [];
	
	public function vehicleMake()
	{
		return $this->belongsTo('VehicleMake');
	}
	
	public function maliketiContentVehicles()
	{
		return $this->hasMany('MaliketiContentVehicle');
	}

}