<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class productNotController extends Controller
{
    public function index(){
        $apigaming = Http::get('https://bored-api.appbrewery.com/random');
        return view('index',compact('apigaming'));
    }
}
