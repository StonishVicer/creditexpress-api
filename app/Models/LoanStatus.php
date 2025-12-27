<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanStatus extends Model
{
    use HasFactory;

    protected $table = 'loan_statuses';

    protected $fillable = [
        'name_status',
    ];

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
