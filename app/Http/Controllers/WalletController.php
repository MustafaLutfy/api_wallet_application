<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;

class WalletController extends Controller
{

    public function index()
    {
        return response()->json([
            'wallet' => Wallet::where('user_id', auth()->user()->id)->get(),
        ]);
    }

   
}
