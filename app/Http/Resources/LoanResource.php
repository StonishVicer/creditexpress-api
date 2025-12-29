<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'loan_status_id' => $this->loan_status_id,
            'principal_amount' => (float) $this->principal_amount,
            'interest_rate' => (float) $this->interest_rate,
            'payment_term' => $this->payment_term,
            'number_installments' => $this->number_installments,
            'interest_to_collect' => (float) $this->interest_to_collect,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}