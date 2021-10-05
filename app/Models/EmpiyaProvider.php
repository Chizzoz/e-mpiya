<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaProvider extends Model
{
	protected $fillable = [];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'provider_slug';
	}
	public function empiyaTransactions()
	{
		return $this->hasMany('App\Models\EmpiyaTransaction');
	}
}
