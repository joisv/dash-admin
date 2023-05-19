<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
   public function index() {
      $tokenNames = PersonalAccessToken::where('tokenable_type', User::class)
      ->pluck('name')
      ->toArray();
        return Inertia::render('Tokens', [
         'name' => $tokenNames
        ]);
   }

   public function gettoken(Request $request){
      
      $token = $request->user()->createToken($request->token_name);
      return redirect()->route('token')->with('message', $token->plainTextToken);
   }
}
