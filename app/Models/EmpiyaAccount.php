<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaAccount extends Model
{
	public function empiyaAccountType()
	{
		return $this->belongsTo('App\Models\EmpiyaAccountType');
	}
	
	public function empiyaAccountLimits()
	{
		return $this->hasMany('App\Models\EmpiyaAccountLimit');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
