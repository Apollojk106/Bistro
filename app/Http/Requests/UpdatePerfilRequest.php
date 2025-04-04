<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdatePerfilRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check(); // Garante que o usuário esteja autenticado
    }

    public function rules()
    {
        return [
            'nome' => 'required|string|max:255',
            'telefone' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:9',
            'rua' => 'nullable|string|max:255',
            'bairro' => 'nullable|string|max:255',
            'numero_residencia' => 'nullable|string|max:10',
            'complemento' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'nome.required' => 'O campo Nome é obrigatório.',
            'telefone.max' => 'O telefone pode ter no máximo 20 caracteres.',
            'cep.max' => 'O CEP pode ter no máximo 9 caracteres.',
            'rua.max' => 'A rua pode ter no máximo 255 caracteres.',
            'bairro.max' => 'O bairro pode ter no máximo 255 caracteres.',
            'numero_residencia.max' => 'O número de residência pode ter no máximo 10 caracteres.',
            'complemento.max' => 'O complemento pode ter no máximo 255 caracteres.',
        ];
    }
}

