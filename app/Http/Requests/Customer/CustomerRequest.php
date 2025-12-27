<?php

namespace App\Http\Requests\Customer;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name'                   => 'required|string|max:255',
            'number_id'              => ['required', 'max:9', Rule::unique('customers')->ignore($this->route('id'))],
            'phone'                  => 'required|between:11,14',
            'address'                => 'required|string',
            'payment_classification' => 'required|in:GOOD,REGULAR,BAD',
            'status'                 => 'required|in:ACTIVE,INACTIVE'
        ];
    }

    public function messages(): array
    {
        return [
            'number_id.unique' => 'El número de cédula ya existe.',
            'required'         => 'El campo :attribute es obligatorio.',
            'in'               => 'El valor seleccionado para :attribute es inválido.',
        ];
    }
}