<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_balance',
        'total_income',
        'total_expenses',
    ];



    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
