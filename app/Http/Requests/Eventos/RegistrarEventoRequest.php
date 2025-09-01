<?php

namespace App\Http\Requests\Eventos;

use Illuminate\Foundation\Http\FormRequest;

class RegistrarEventoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'evento_id' => ['required', 'numeric']
        ];
    }

}
