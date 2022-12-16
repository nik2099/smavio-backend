<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    // protected $hidden = ['user_id'];

    public function fields(){
        return $this->hasMany(TemplateField::class);
    }
    
    public function campaigns(){
        return $this->hasMany(Campaign::class);
    }
    
    public function category(){
        return $this->belongsTo(Category::class);
    }
    
    public function users(){
    	return $this->belongsToMany(User::class,'apps','template_id','user_id');
    }
}
