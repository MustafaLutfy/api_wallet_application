<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load("wallet");
        return response()->json([
            'user' => $user,
        ]);
    }

}
