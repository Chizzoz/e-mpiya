<?php namespace App\models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class CreativeContent extends Eloquent {

	protected $fillable = [];
	
	public function creativeContentIndustries()
	{
		return $this->hasMany('CreativeContentIndustry');
	}
	
	public function creativeContentIndustrySubs()
	{
		return $this->hasMany('CreativeContentIndustrySub');
	}
	
	public function creativeContentSoftwares()
	{
		return $this->hasMany('CreativeContentSoftware');
	}
	
	public function creativeContentSoftwareSubs()
	{
		return $this->hasMany('CreativeContentSoftwareSub');
	}
	
	public function creativeContentType()
	{
		return $this->belongsTo('CreativeContentType');
	}
	
	public function creativeContentTutorial()
	{
		return $this->hasOne('CreativeContentTutorial');
	}
	
	public function creativeContentArticle()
	{
		return $this->hasOne('CreativeContentArticle');
	}
	
	public function content()
	{
		return $this->belongsTo('Content');
	}
	
	public function creativeContentPortfolio()
	{
		return $this->hasOne('CreativeContentPortfolio');
	}
	
}