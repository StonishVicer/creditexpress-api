<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoanStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_status' => ['required', 'string', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'name_status.required' => 'El nombre del estado es requerido.',
            'name_status.string' => 'El nombre del estado debe ser una cadena de texto.',
            'name_status.max' => 'El nombre del estado no puede exceder los 255 caracteres.',
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
