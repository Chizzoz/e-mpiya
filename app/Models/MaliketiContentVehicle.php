<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContentVehicle extends Eloquent {

	protected $fillable = [];
	
	public function vehicleModel()
	{
		return $this->belongsTo('VehicleModel');
	}
	
	public function vehicleMake()
	{
		return $this->belongsTo('VehicleMake');
	}
	
	public function maliketiContent()
	{
		return $this->belongsTo('MaliketiContent');
	}

}