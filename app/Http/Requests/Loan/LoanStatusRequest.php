<?php

namespace App\Http\Requests\Loan;

use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class LoanStatusRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name_status' => [
                'required', 
                'string', 
                'max:255', 
                // Permite actualizar el mismo registro sin error de duplicidad
                Rule::unique('loan_statuses', 'name_status')->ignore($this->route('id'))
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'El :attribute es requerido.',
            'unique'   => 'Este :attribute ya se encuentra registrado.',
            'max'      => 'El :attribute es demasiado largo.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name_status' => 'nombre del estado',
        ];
    }
}