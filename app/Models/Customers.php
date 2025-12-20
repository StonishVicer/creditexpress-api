<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customers extends Model
{
    use HasFactory;

    protected $table = 'customers';

    protected $fillable = [
        'name',
        'number_id',
        'phone',
        'address',
        'payment_classification',
        'status',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loans::class);
    }
}
