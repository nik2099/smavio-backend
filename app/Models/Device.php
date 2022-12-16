<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Device extends Model
{
	use SoftDeletes;
	
    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function mainuser(){
        return $this->belongsTo(User::class,'parent_user_id');
    }
    
}
