<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoansResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'capital_prestado' => $this->principal_amount,
            'tasa_de_interes' => $this->interest_rate,
            'plazo_de_pago' => $this->payment_term,
            'numero_de_cuotas' => $this->number_installments,
            'interes_a_cobrar' => $this->interest_to_collect,
        ];
    }
}
