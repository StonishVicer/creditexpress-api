<?php

namespace App\Http\Requests\Loan;

use App\Http\Requests\BaseRequest;

class LoanRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'customer_id'         => 'required|exists:customers,id',
            'loan_status_id'      => 'required|exists:loan_statuses,id',
            'principal_amount'    => 'required|numeric|min:0',
            'interest_rate'       => 'required|numeric|min:10|max:12',
            'payment_term'        => 'required|integer|min:3|max:6',
            'number_installments' => 'required|integer|min:3|max:6',
            'interest_to_collect' => 'required|numeric|min:0',
        ];
    }

    public function attributes(): array
    {
        return [
            'customer_id'         => 'cliente',
            'loan_status_id'      => 'estado del préstamo',
            'principal_amount'    => 'monto principal',
            'interest_rate'       => 'tasa de interés',
            'payment_term'        => 'plazo de pago',
            'number_installments' => 'número de cuotas',
            'interest_to_collect' => 'interés a recaudar',
        ];
    }

    public function messages(): array
    {
        return [
            'required'      => 'El campo :attribute es obligatorio.',
            'exists'        => 'El :attribute seleccionado no existe.',
            'min'           => 'El valor mínimo para :attribute es :min.',
            'max'           => 'El valor máximo para :attribute es :max.',
            'numeric'       => 'El campo :attribute debe ser un número.',
            'integer'       => 'El campo :attribute debe ser un número entero.',
        ];
    }
}