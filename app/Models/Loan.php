<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'customer_id',
        'principal_amount',
        'interest_rate',
        'payment_term',
        'number_installments',
        'interest_to_collect',
        'loan_status_id',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function loanStatus(): BelongsTo
    {
        return $this->belongsTo(LoanStatus::class);
    }
}
