<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingProfile extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['user_id'];

    public function user(){
        return $this->belongsTo(BillingProfile::class);
    }
}
