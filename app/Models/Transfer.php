<?php

namespace App\Models;

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

}
