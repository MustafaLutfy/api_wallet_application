<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use DB;
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
        return Transfer::userTransfers(auth()->id())->latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransferRequest $request)
    {
        $transferData = $request->validated();
        $amount = $transferData['amount'];
        // use database transactions for more than 1 query manipulates data

        DB::beginTransaction();
        try {
            // use ->first() directly not ->get()->first() allocates less memory
            // always lock the rows seems critical like wallets , bookings , product quantities etc...
            // use whereRelation or whereHas to fetch the child row without fetching the parent row
            $sourceWallet = Wallet::whereRelation('user','phone',$request->user()->phone)
                ->sharedLock()
                ->firstOr(callback: fn() => abort(400,'not found wallet'));
            $destinationWallet = Wallet::sharedLock()->whereUserId(auth()->id())->first();
            // work with negative conditions to get rid of else statements

            if($sourceWallet->current_balance < $amount){
                return response()->json([
                    'message' => "you don't have enough in you balance",
                ]);

            }

            Transfer::create([
                'source_user_id' => auth()->user()->id,
                'destination_user_id' => $destinationWallet->user_id,
                'amount' => $transferData['amount'],
                'category'=> $transferData['category'],
                'transfer_type'=> $transferData['transfer_type'],
            ]);
            $sourceWallet->update([
                'current_balance' => $sourceWallet->current_balance - $amount,
                'total_expenses' => $sourceWallet->total_expenses + $amount,
            ]);
            $destinationWallet->update([
                'current_balance' => $destinationWallet->current_balance + $amount,
                'total_income' => $sourceWallet->total_income + $amount,
            ]);

            DB::commit();
            return response()->json([
                'message' => $transferData,
            ]);
        }catch (\Exception $e){
            DB::rollBack();
            logger()->critical($e->getMessage(),[self::class]);
            abort(500,'Server Error');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $transfer = Transfer::userTransfers(auth()->id())
            ->with(['destinationUser','sourceUser'])
            ->findOrFail($id);
        return response()->json($transfer);
    }

}
