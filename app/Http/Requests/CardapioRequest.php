<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CardapioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Nome' => 'required|string|max:255',
            'Imagem' => 'required|string|max:255',
            'Descricao' => 'required|string',
            'Valor' => 'required|numeric',
            'categoria' => 'required|string', // Categoria pode ser nova ou existente
            'Igredientes' => 'required|string',
            'Desconto' => 'nullable|numeric',
            'Disponibilidade' => 'required|string',
        ];
    }

    /**
     * Obtenha as mensagens de erro personalizadas para as regras de validação.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'Nome.required' => 'O nome do item é obrigatório.',
            'Nome.string' => 'O nome do item deve ser uma string.',
            'Nome.max' => 'O nome do item não pode ter mais de 255 caracteres.',
            'Imagem.required' => 'A imagem é obrigatória.',
            'Imagem.string' => 'A imagem deve ser uma string.',
            'Imagem.max' => 'O nome da imagem não pode ter mais de 255 caracteres.',
            'Descricao.required' => 'A descrição é obrigatória.',
            'Descricao.string' => 'A descrição deve ser uma string.',
            'Valor.required' => 'O valor é obrigatório.',
            'Valor.numeric' => 'O valor deve ser um número.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.string' => 'A categoria deve ser uma string.',
            'Igredientes.required' => 'Os ingredientes são obrigatórios.',
            'Igredientes.string' => 'Os ingredientes devem ser uma string.',
            'Desconto.numeric' => 'O desconto deve ser um número.',
            'Disponibilidade.string' => 'A disponibilidade deve ser uma string.',
        ];
    }
}
