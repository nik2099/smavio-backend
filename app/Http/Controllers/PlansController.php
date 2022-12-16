<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class PlansController extends Controller
{
    public function index(Request $request){
        return response()->json(Plan::all(), 200);
    }
}
