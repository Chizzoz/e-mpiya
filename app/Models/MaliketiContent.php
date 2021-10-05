<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MaliketiContent extends Eloquent {

	protected $fillable = [];
	
	public function maliketiContentPet()
	{
		return $this->hasOne('MaliketiContentPet');
	}
	
	public function maliketiContentProfessions()
	{
		return $this->hasMany('MaliketiContentProfession');
	}
	
	public function maliketiContentService()
	{
		return $this->hasOne('MaliketiContentService');
	}

	
	public function maliketiContentMen()
	{
		return $this->hasOne('MaliketiContentMen');
	}

	
	public function maliketiContentEducation()
	{
		return $this->hasOne('MaliketiContentEducation');
	}

	
	public function maliketiContentType()
	{
		return $this->belongsTo('MaliketiContentType');
	}
	
	public function maliketiContentSubType()
	{
		return $this->belongsTo('maliketiContentSubType');
	}
	
	public function maliketiContentRealEstate()
	{
		return $this->hasOne('MaliketiContentRealEstate');
	}

	
	public function maliketiContentEmployment()
	{
		return $this->hasOne('MaliketiContentEmployment');
	}

	
	public function maliketiContentPersonal()
	{
		return $this->hasOne('MaliketiContentPersonal');
	}

	
	public function maliketiContentMisc()
	{
		return $this->hasOne('MaliketiContentMisc');
	}

	
	public function maliketiContentElectronics()
	{
		return $this->hasOne('MaliketiContentElectronic');
	}

	
	public function maliketiContentWomen()
	{
		return $this->hasOne('MaliketiContentWomen');
	}

	
	public function maliketiContentInfant()
	{
		return $this->hasOne('MaliketiContentInfant');
	}

	
	public function content()
	{
		return $this->belongsTo('Content');
	}

	
	public function maliketiContentStatus()
	{
		return $this->belongsTo('MaliketiContentStatus');
	}

	
	public function maliketiContentVehicles()
	{
		return $this->hasOne('MaliketiContentVehicles');
	}

}