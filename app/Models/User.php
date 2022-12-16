<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'newsletter',
        'user_id',
        'plan_id',
        'pucode'
    ];

    protected $appends = ['type', 'name', 'current_subscription', 'cancelled', 'upcoming_invoice','name_initials','no_of_myapps'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        // 'pucode',
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

    public function billing_profile(){
        return $this->hasOne(BillingProfile::class);
    }

    public function sub_users(){
        return $this->hasMany(User::class);
    }
    

    public function parent_user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function notification_settings()
    {
        return $this->hasOne(NotificationSettings::class);
    }

    public function sub_user_invitations(){
        return $this->hasMany(SubUserInvitation::class);
    }

    public function getTypeAttribute(){
        if($this->user_id == null && $this->role == null){
            return 'user';
        }else if($this->role == "admin"){
            return 'admin';
        }else{
        	return 'subuser';
        }
        
        if($this->role == "admin"){
            return 'admin';
        }elseif($this->user_id == null){
            return 'user';
        }else{
        	return 'subuser';
        }
    }

    public function getNameAttribute(){
        return $this->first_name . ' ' . $this->last_name;
    }
    
    public function getNoOfMyappsAttribute(){
        return $this->apps->count();
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    
    public function getNameInitialsAttribute() {
        $trimed_firstname = trim($this->first_name);
        $initials = $trimed_firstname[0];
        $firstname_arr = explode(" ", trim($this->first_name));
        if(!empty(trim($this->last_name))){
            $initials.= trim($this->last_name)[0];    
        }elseif(count($firstname_arr) > 1){
            $initials.= end($firstname_arr)[0];
        }
        return $initials;
    }
    
    public function getCurrentSubscriptionAttribute() {
    	if($this->plan_id != 0 && $this->plan->title){
            return $this->plan->title;
        }else{
            return null;
        }
        
    }

    public function getCancelledAttribute() {
        if($this->subscribed('default')){
            return $this->subscription('default')->canceled();
        }else{
            return null;
        }
    }

    public function getUpcomingInvoiceAttribute(){
        return $this->upcomingInvoice();
    }
	
	public function campaigns(){
        return $this->hasMany(Campaign::class);
    }
    
    public function trashedCampaigns(){
        return $this->hasMany(Campaign::class)->withTrashed()->whereNotNull('campaigns.deleted_at');
    }
    
    public function mydevices(){
        return $this->hasMany(Device::class);
    }
    
    public function alldevices(){
        return $this->hasMany(Device::class,'parent_user_id');
    }
    
    public function allcampaignSubscription(){
        return $this->hasMany(CampaignSubscription::class,'parent_user_id');
    }

    public function apps(){
    	return $this->belongsToMany(Template::class,'apps','user_id','template_id');
    }
    

}
