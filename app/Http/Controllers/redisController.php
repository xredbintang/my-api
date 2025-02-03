<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class redisController extends Controller
{
    public function index(Request $request){
        $data = Cache::remember('users',now()->addMinutes(1),function(){
            return [1,2,3,4,5,6,];
        });

        return $data;
    }
}
