<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaTransaction extends Model
{
	protected $fillable = [];
	
	public function empiyaProvider()
	{
		return $this->belongsTo('App\Models\EmpiyaProvider');
	}
	
	public function relatedTransaction()
	{
		return $this->belongsTo('App\Models\EmpiyaTransaction', 'related_transaction_id');
	}
	
	public function empiyaTransactionStatus()
	{
		return $this->belongsTo('App\Models\EmpiyaTransactionStatus');
	}
	
	public function empiyaTransactionType()
	{
		return $this->belongsTo('App\Models\EmpiyaTransactionType');
	}
	
	public function empiyaTransactionHistories()
	{
		return $this->hasMany('App\Models\EmpiyaTransactionHistory');
	}
	
	public function sender()
	{
		return $this->belongsTo('App\User', 'sender_id');
	}
	
	public function receiver()
	{
		return $this->belongsTo('App\User', 'receiver_id');
	}
}
