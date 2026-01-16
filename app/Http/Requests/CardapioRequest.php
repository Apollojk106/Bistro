<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardapioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'Nome' => 'required|string|max:255',
            'Imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Descricao' => 'required|string',
            'Valor' => 'required|numeric',
            'categoria' => 'required|string',
            'Igredientes' => 'required|string',
            'Desconto' => 'nullable|numeric',
            'Disponibilidade' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'Nome.required' => 'O nome do item é obrigatório.',
            'Nome.string' => 'O nome do item deve ser uma string.',
            'Nome.max' => 'O nome do item não pode ter mais de 255 caracteres.',
            'Descricao.required' => 'A descrição é obrigatória.',
            'Descricao.string' => 'A descrição deve ser uma string.',
            'Valor.required' => 'O valor é obrigatório.',
            'Valor.regex' => 'O valor deve ser um número válido (ex: 29,99 ou 29.99).',
            'categoria.required' =w> 'A categoria é obrigatória.',
            'categoria.string' => 'A categoria deve ser uma string.',
            'Igredientes.required' => 'Os ingredientes são obrigatórios.',
            'Igredientes.string' => 'Os ingredientes devem ser uma string.',
            'Desconto.regex' => 'O desconto deve ser um número válido.',
            'Disponibilidade.string' => 'A disponibilidade deve ser uma string.',
        ];
    }
}
