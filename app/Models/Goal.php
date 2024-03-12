<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'target'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
