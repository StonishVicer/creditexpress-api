<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
}
