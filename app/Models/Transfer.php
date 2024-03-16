<?php

namespace App\Models;

use App\Enums\ExpenseCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_user_id',
        'destination_user_id',
        'amount',
        'category',
        'transfer_type'
    ];
    protected $casts = [
        'category' => ExpenseCategory::class
    ];
    // use scopes for redundant queries
    public function scopeUserTransfers(Builder $query,int $userId)
    {
        return $query->orWhere(['destination_user_id' => $userId,'source_user_id' => $userId]);
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class,'source_user_id');
    }
    public function destinationUser()
    {
        return $this->belongsTo(User::class,'destination_user_id');
    }

}
