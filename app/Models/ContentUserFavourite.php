<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentUserFavourite extends Model {
	
	use SoftDeletes;
	
	protected $dates = ['deleted_at'];
	
	protected $fillable = ['content_id',
							'user_id',
							'favourite'];
	
	public function content()
	{
		return $this->belongsTo('Content');
	}
	
	public function user()
	{
		return $this->belongsTo('User');
	}

}
