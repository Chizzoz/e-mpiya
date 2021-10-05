<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Bedroom extends Eloquent {

	//protected $fillable = [];
	
	public function maliketiContentRealEstates()
	{
		return $this->hasMany('MaliketiContentRealEstate');
	}

}