<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CompanyUserSpecific extends Eloquent {

	protected $fillable = [];
	
	public function companyUsers()
	{
		return $this->hasMany('CompanyUser');
	}

}