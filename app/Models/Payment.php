<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'enrollment_id',
        'total_fee',
        'amount_paid',
        'amount_due',
        'last_payment_date',
        'status',
    ];
    

    public function enrollment() {
        return $this->belongsTo(Enrollment::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
