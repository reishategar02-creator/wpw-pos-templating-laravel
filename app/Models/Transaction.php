<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number', 'user_id', 'customer_name',
        'subtotal', 'discount', 'tax', 'other_fee', 'grand_total',
        'paid_amount', 'change_amount', 'payment_method', 'status',
    ];

    protected $casts = [
        'subtotal'      => 'decimal:2',
        'discount'      => 'decimal:2',
        'tax'           => 'decimal:2',
        'other_fee'     => 'decimal:2',
        'grand_total'   => 'decimal:2',
        'paid_amount'   => 'decimal:2',
        'change_amount' => 'decimal:2',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}