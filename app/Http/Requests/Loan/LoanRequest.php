<?php

namespace App\Http\Requests\Loan;

use App\Http\Requests\BaseRequest;


class LoanRequest extends BaseRequest
{
    public function rules(): array
    {
        $presenceRule = $this->isMethod('PATCH') ? 'sometimes' : 'required';
    
        return [
            'customer_id'         => [$presenceRule, 'exists:customers,id'],
            'loan_status_id'      => [$presenceRule, 'exists:loan_statuses,id'],
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
            'customer_id.exists' => 'El cliente seleccionado no existe.',
            'loan_status_id.exists' => 'El estado de prestamo seleccionado no existe.',
            'interest_rate.min' => 'La tasa de interés no puede ser menor a 10%.',
            'interest_rate.max' => 'La tasa de interés no puede ser mayor a 12%.',
            'payment_term.min' => 'El plazo mínimo es de 3 meses.',
            'number_installments.min' => 'El número mínimo de cuotas es 3.',
        ];
    }
}