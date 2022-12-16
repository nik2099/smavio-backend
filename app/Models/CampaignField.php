<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignField extends Model
{
    use HasFactory;
    
    protected $guarded = [];
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    
    public function getValueAttribute($value)
    {
    	if($this->type == 'image'){
    		if($value == "" || $value == null){
    			return asset('images/schuh2.jpg');
    		}else{
    			if (filter_var($value, FILTER_VALIDATE_URL)) {
    				
    				return $value;
    			}else{
    				return asset($value);	
    			}
    		}
    	}else{
    		return $value;	
    	}
        
    }
    
    public function setValueAttribute($value)
    {
    	if($this->type == 'image'){
    		if($value == "" || $value == null){
    			$this->attributes['value'] = 'images/schuh2.jpg';
    		}else{
    			if (filter_var($value, FILTER_VALIDATE_URL)) {
    				$this->attributes['value'] = str_replace(asset(''),'',$value);
    			}else{
    				$this->attributes['value'] = $value;	
    			}
    		}
    	}else{
    		$this->attributes['value'] = $value;
    	}
        
    }
    
    public function getBinaryImageAttribute($value)
    {
    	if($this->type == 'image'){
    		if($value == "" || $value == null){
    			return "";
    		}else{
    			return base64_encode($value);
    		}
    	}else{
    		return $value;	
    	}
        
    }
}
