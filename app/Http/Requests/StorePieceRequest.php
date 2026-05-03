<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePieceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'peso_teorico' => 'required|numeric|min:0',
            'peso_real' => 'nullable|numeric|min:0',
        ];
    }
}
