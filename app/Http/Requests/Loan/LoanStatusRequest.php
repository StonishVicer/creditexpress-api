<?php

namespace App\Http\Requests\Loan;

use App\Http\Requests\BaseRequest;

class LoanStatusRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name_status' => ['required', 'string', 'max:255', 'unique:loan_statuses,name_status']
        ];
    }

    public function messages(): array
    {
        return [
            'name_status.required' => 'El nombre del estado es requerido.',
            'name_status.unique' => 'Este estado ya se encuentra registrado.',
            'name_status.max' => 'El nombre es demasiado largo.',
        ];
    }
}