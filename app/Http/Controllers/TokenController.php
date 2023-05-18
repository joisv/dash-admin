<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TokenController extends Controller
{
   public function index() {
        return Inertia::render('Tokens');
   }
}
