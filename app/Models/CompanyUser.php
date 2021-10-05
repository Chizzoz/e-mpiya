<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CompanyUser extends Eloquent {

	protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
	public function companyUserSpecific()
	{
		return $this->belongsTo('CompanyUserSpecific');
	}

}