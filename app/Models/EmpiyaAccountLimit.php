<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaAccountLimit extends Model
{
	protected $fillable = [];
	
	public function empiyaAccountLimitType()
	{
		return $this->belongsTo('App\Models\EmpiyaAccountLimitType');
	}
	
	public function empiyaAccount()
	{
		return $this->belongsTo('App\Models\EmpiyaAccount');
	}
}
