<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoansStatus extends Model
{
    use HasFactory;

    protected $table = 'loans_status';

    protected $fillable = [
        'name_status',
    ];

    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loans::class);
    }
}
