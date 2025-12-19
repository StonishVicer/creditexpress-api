<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CustomersRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $customerId = $this->route('id');

        return [
            'name' => ['required', 'max:255'],
            'number_id' => ['required', 'max:9', Rule::unique('customers', 'number_id')->ignore($customerId)],
            'phone' => ['required', 'between:11,14'],
            'address' => 'required',
            'payment_classification' => ['required', 'in:GOOD,REGULAR,BAD'],
            'status' => ['required', 'in:ACTIVE,INACTIVE']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del cliente es requerido.',
            'name.max' => 'El nombre del cliente no puede tener mas de 255 caracteres.',
            'number_id.required' => 'El numero de cedula es requerido.',
            'number_id.max' => 'El numero de cedula no puede tener mas de 9 caracteres.',
            'number_id.unique' => 'El numero de cedula ya existe.',
            'phone.required' => 'El numero de telefono es requerido.',
            'phone.between' => 'El numero de telefono requiere entre 11 y 14 caracteres.',
            'address.required' => 'La direccion del cliente es requerida.',
            'payment_classification.required' => 'La clasificacion de pago es requerida.',
            'payment_classification.in' => 'La clasificacion de pago seleccionada es invalida. Los campos validos son GOOD, REGULAR o BAD.',
            'status.required' => 'El estado es requerido.',
            'status.in' => 'El estado seleccionado es invalido. Los campos validos son ACTIVE o INACTIVE.',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
            'error' => true,
            'status' => 422
        ], 422));
    }
}
