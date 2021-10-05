<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaTransactionHistory extends Model
{
	protected $fillable = [];
	
	public function empiyaTransaction()
	{
		return $this->belongsTo('App\Models\EmpiyaTransaction');
	}
	
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
