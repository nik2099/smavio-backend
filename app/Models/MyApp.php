<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyApp extends Pivot
{
    use SoftDeletes;
    protected $table = 'apps';
    

  
}
