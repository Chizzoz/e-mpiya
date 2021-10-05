<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'user_type_id', 'social_user_id', 'username', 'username_slug', 'user_profile_picture', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
	
	// rote key name
	public function getRouteKeyName()
	{
		return 'username_slug';
	}
	
	// Relationships
	public function individualUser()
	{
		return $this->hasOne('App\Models\IndividualUser');
	}
	
	public function userProfessions()
	{
		return $this->hasMany('App\Models\UserProfession');
	}
	
	public function userCreativeIndustrySub()
	{
		return $this->hasMany('App\Models\UserCreativeIndustrySub');
	}
	
	public function companyUser()
	{
		return $this->hasOne('App\Models\CompanyUser');
	}
	
	public function userType()
	{
		return $this->belongsTo('App\Models\UserType');
	}
	
	public function contents()
	{
		return $this->hasMany('App\Models\Content');
	}
	
	public function userCreativeIndustry()
	{
		return $this->hasMany('App\Models\UserCreativeIndustry');
	}
	
	public function userRole()
	{
		return $this->belongsTo('App\Models\UserRole');
	}
	
	public function empiyaAccounts()
	{
		return $this->hasMany('App\Models\EmpiyaAccount');
	}
	
	public function empiyaTransactionHistories()
	{
		return $this->hasMany('App\Models\EmpiyaTransactionHistory');
	}
	
	public function empiyaTransactionSender()
	{
		return $this->hasMany('App\Models\EmpiyaTransaction', 'sender_id');
	}
	
	public function empiyaTransactionReceiver()
	{
		return $this->hasMany('App\Models\EmpiyaTransaction', 'receiver_id');
	}
	
	public function location()
	{
		return $this->belongsTo('App\Models\Location');
	}
	
	public function comments()
	{
		return $this->hasMany('App\Models\Comment');
	}
	
	public function groupUsers()
	{
		return $this->hasOne('App\Models\GroupUser');
	}
	
	public function userMobile()
	{
		return $this->belongsTo('App\Models\UserMobile');
	}
	
	public function contentUserFavourites()
	{
		return $this->hasMany('App\Models\ContentUserFavourite');
	}
	
	public function contentUserRatings()
	{
		return $this->hasMany('App\Models\ContentUserRating');
	}
	
	public function userRelationships()
	{
		return $this->hasMany('App\Models\UserRelationship', 'associator_id');
	}
	
	public function userAccesses()
	{
		return $this->hasMany('App\Models\UserAccess');
	}
	
	public function userHeadlineSourcePreferences()
	{
		return $this->hasMany('App\Models\UserHeadlineSourcePreference');
	}
}
