<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateField extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function template(){
        return $this->belongsTo(Template::class);
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
    
}
