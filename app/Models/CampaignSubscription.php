<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CampaignSubscription extends Model
{

    protected $guarded = [];

   

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function parentUser(){
        return $this->belongsTo(User::class,'parent_user_id');
    }
    
    public function campaign(){
        return $this->belongsTo(Campaign::class);
    }
    

}
