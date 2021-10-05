<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaAccountLimitType extends Model
{
	protected $fillable = [];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'account_limit_type_slug';
	}
	
	public function empiyaAccountLimits()
	{
		return $this->hasMany('App\Models\EmpiyaAccountLimit');
	}
}
