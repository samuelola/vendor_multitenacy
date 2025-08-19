<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RevenueHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'transaction_type',
        'revenue_amount',
        'user_id',
        'date',
    ];

    
}
