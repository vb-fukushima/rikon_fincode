<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'fincode_invoice_id',
        'invoice_url',
        'status',
        'amount',
        'customer_name',
        'customer_email',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];
}
