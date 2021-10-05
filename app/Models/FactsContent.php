<?php namespace App\models;

use Illuminate\Database\Eloquent\Model;

class FactsContent extends Model {

	protected $fillable = [];
	
	public function content()
	{
		return $this->belongsTo('Content');
	}

}
