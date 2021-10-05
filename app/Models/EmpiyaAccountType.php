<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmpiyaAccountType extends Model
{
	protected $fillable = [];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'account_type_slug';
	}
	
	public function empiyaAccounts()
	{
		return $this->hasMany('App\Models\EmpiyaAccount');
	}
}
