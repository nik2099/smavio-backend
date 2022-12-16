<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model
{
    use HasFactory,SoftDeletes;
    
    protected $guarded = [];
    
    protected $appends = ['all_devices','no_of_devices'];
    
    protected $casts = [
	    'created_at'  => 'datetime:Y-m-d h:i A'
	];
    
    public function template(){
        return $this->belongsTo(Template::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function fields(){
        return $this->hasMany(CampaignField::class);
    }
    
    public function childCampaign(){
    	return $this->hasOne(Campaign::class);
    }
    
    public function parentCampaign(){
    	return $this->belongsTo(Campaign::class);
    }
    
    public function devices(){
    	return $this->hasMany(Device::class);
    }
    
    public function getAllDevicesAttribute(){
    	$cam_ids = [];
    	if($this->campaign_id == null){
    		$cam_ids[] = $this->childCampaign->id;
    		
    	}else{
    		$cam_ids[] = $this->campaign_id;
    	}
    	$cam_ids[] = $this->id;
    	return Device::whereIn('campaign_id',$cam_ids)->get();
    }
    
    public function getNoOfDevicesAttribute(){
    	
    	return $this->all_devices->count();
    }
    public function campaign(){
        return $this->hasMany(CampaignSubscription::class,'campaign_id');
    }
}
