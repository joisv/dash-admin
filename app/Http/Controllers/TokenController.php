<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TokenController extends Controller
{
   public function index() {
      
        return Inertia::render('Tokens');
   }

   public function gettoken(Request $request){
      $token = $request->user()->createToken($request->token_name);
      return ['token' => $token->plainTextToken];
   }
}
