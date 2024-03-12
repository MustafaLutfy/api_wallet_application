<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Wallet;
use App\Http\Requests\StoreTransferRequest;

class TransferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        $transferData = $request->validated();

        $destination_user = User::where('phone', $transferData['phone'])->get()->first();
        $amount = $transferData['amount'];

        $transfer = Transfer::create([
            'source_user_id' => auth()->user()->id,
            'destination_user_id' => $destination_user->id,
            'amount' => $transferData['amount'],
            'category'=> $transferData['category'],
            'transfer_type'=> $transferData['transfer_type'],
        ]);

        $sourceWallet = Wallet::where('user_id', auth()->user()->id)->get()->first();
        $destinationWallet = Wallet::where('user_id', $destination_user->id)->get()->first();

        if($sourceWallet->current_balance >= $amount){
            $sourceWallet->update([
                'current_balance' => $sourceWallet->current_balance - $amount,
                'total_expenses' => $sourceWallet->total_expenses + $amount,
            ]);
            $destinationWallet->update([
                'current_balance' => $destinationWallet->current_balance + $amount,
                'total_income' => $sourceWallet->total_income + $amount,
            ]);
        }
        else{
            return response()->json([
                'message' => "you don't have enough in you balance",
            ]);
        }
        
       
        return response()->json([
            'message' => $transferData,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
