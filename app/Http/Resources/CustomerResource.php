<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'number_id' => $this->number_id,
            'phone' => $this->phone,
            'address' => $this->address,
            'payment_classification' => $this->payment_classification,
            'status' => $this->status,
        ];
    }
}

