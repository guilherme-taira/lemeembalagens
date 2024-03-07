<?php

namespace App\Http\Controllers\Bling;

use App\Http\Controllers\Controller;
use App\Models\token;
use Illuminate\Http\Request;

class tokenApi extends Controller
{
    public function saveToken(Request $request){
        token::saveToken($request);
    }
}
