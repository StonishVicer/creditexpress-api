<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class LoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $presenceRule = $this->isMethod('PATCH') ? 'sometimes' : 'required';
    
        return [
            'customer_id'         => [$presenceRule, 'exists:customers,id'], // Crítico para tests
            'loan_status_id'      => [$presenceRule, 'exists:loan_statuses,id'], // Crítico para tests
            'principal_amount'    => [$presenceRule, 'numeric', 'min:0'],
            'interest_rate'       => [$presenceRule, 'numeric', 'min:10', 'max:12'],
            'payment_term'        => [$presenceRule, 'integer', 'min:3', 'max:6'],
            'number_installments' => [$presenceRule, 'integer', 'min:3', 'max:6'],
            'interest_to_collect' => [$presenceRule, 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'principal_amount.required' => 'El capital prestado es requerido.',
            'principal_amount.numeric' => 'El capital prestado debe ser un número.',
            'principal_amount.min' => 'El capital prestado no puede ser negativo.',
            'interest_rate.required' => 'La tasa de interés es requerida.',
            'interest_rate.numeric' => 'La tasa de interés debe ser un número.',
            'interest_rate.min' => 'La tasa de interés no puede ser menor a 10.',
            'interest_rate.max' => 'La tasa de interés no puede ser mayor a 12.',
            'payment_term.required' => 'El plazo de pago es requerido.',
            'payment_term.integer' => 'El plazo de pago debe ser un entero.',
            'payment_term.min' => 'El plazo de pago no puede ser menor a 3.',
            'payment_term.max' => 'El plazo de pago no puede ser mayor a 6.',
            'number_installments.required' => 'El número de cuotas es requerido.',
            'number_installments.integer' => 'El número de cuotas debe ser un entero.',
            'number_installments.min' => 'El número de cuotas no puede ser menor a 3.',
            'number_installments.max' => 'El número de cuotas no puede ser mayor a 6.',
            'interest_to_collect.required' => 'El interés a cobrar es requerido.',
            'interest_to_collect.numeric' => 'El interés a cobrar debe ser un número.',
            'interest_to_collect.min' => 'El interés a cobrar no puede ser negativo.',
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
