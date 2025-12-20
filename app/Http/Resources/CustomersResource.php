<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomersResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->name,
            'cedula' => $this->number_id,
            'contacto' => [
                'telefono' => $this->phone,
                'direccion' => $this->address
            ],
            'clasificacion_de_pago' => $this->payment_classification,
            'estado' => $this->status,
        ];
    }
}
