<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaTransactionStatus extends Model
{
	protected $fillable = [];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'transaction_status_slug';
	}
	public function empiyaTransactions()
	{
		return $this->hasMany('App\Models\EmpiyaTransaction');
	}
}
