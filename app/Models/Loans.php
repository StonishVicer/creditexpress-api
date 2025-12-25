<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loans extends Model
{
    use HasFactory;

    protected $table = 'loans';

    protected $fillable = [
        'principal_amount',
        'interest_rate',
        'payment_term',
        'number_installments',
        'interest_to_collect',
    ];

    public function customers(): HasMany
    {
        return $this->hasMany(Customers::class);
    }

    public function loansStatus(): HasMany
    {
        return $this->hasMany(LoansStatus::class);
    }
}
