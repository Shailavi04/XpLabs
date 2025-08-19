<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'amount',
        'transaction_id',
        'payment_method_id',
        'payment_date',
        'status',
        'remarks',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
