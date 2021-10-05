<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class UserHeadlineSourcePreference extends Model
{
    protected $fillable = [];
	
	public function user()
	{
		return $this->belongsTo('User');
	}
	
}
