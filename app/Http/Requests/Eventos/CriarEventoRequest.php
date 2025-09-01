<?php

namespace App\Http\Requests\Eventos;

use Illuminate\Foundation\Http\FormRequest;

class CriarEventoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'data' => ['required', 'date_format:Y-m-d H:i'],
            'descricao' => ['required', 'string', 'max:300'],
            'duracao' => ['required', 'numeric', 'min:1']
        ];
    }

}
