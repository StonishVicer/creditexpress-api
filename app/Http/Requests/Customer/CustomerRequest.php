<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseRequest;

use Illuminate\Validation\Rule;

class CustomerRequest extends BaseRequest
{
    public function rules(): array
    {
        $customerId = $this->route('id');
        $presenceRule = $this->isMethod('PATCH') ? 'sometimes' : 'required';
    
        return [
            'name' => [$presenceRule, 'max:255'],
            'number_id' => [
                $presenceRule, 
                'max:9', 
                Rule::unique('customers', 'number_id')->ignore($customerId)
            ],
            'phone' => [$presenceRule, 'between:11,14'],
            'address' => [$presenceRule],
            'payment_classification' => [$presenceRule, 'in:GOOD,REGULAR,BAD'],
            'status' => [$presenceRule, 'in:ACTIVE,INACTIVE']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del cliente es requerido.',
            'number_id.unique' => 'El numero de cedula ya existe.',
            'phone.between' => 'El numero de telefono requiere entre 11 y 14 caracteres.',
            'payment_classification.in' => 'La clasificacion de pago seleccionada es invalida (GOOD, REGULAR, BAD).',
            'status.in' => 'El estado seleccionado es invalido (ACTIVE, INACTIVE).',
        ];
    }
}