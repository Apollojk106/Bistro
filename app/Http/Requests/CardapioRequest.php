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
            'Desconto' => 'nullable|numeric|min:0|max:100',
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
            'Valor.numeric' => 'O valor deve ser um número válido.',
            'categoria.required' => 'A categoria é obrigatória.',
            'categoria.string' => 'A categoria deve ser uma string.',
            'Igredientes.required' => 'Os ingredientes são obrigatórios.',
            'Igredientes.string' => 'Os ingredientes devem ser uma string.',
            'Desconto.numeric' => 'O desconto deve ser um número.',
            'Desconto.min' => 'O desconto não pode ser menor que 0%.',
            'Desconto.max' => 'O desconto não pode ser maior que 100%.',
            'Disponibilidade.string' => 'A disponibilidade deve ser uma string.',
        ];
    }

    protected function prepareForValidation()
    {
        // Converter Valor do formato brasileiro para americano
        if ($this->has('Valor')) {
            $valor = $this->input('Valor');
            
            // Se for string, converter "29,99" para "29.99"
            if (is_string($valor)) {
                // Remover R$, espaços e outros caracteres
                $valor = str_replace(['R$', '$', ' ', '€'], '', $valor);
                
                // Converter vírgula para ponto
                $valor = str_replace(',', '.', $valor);
                
                $this->merge(['Valor' => $valor]);
            }
        }

        // Converter Desconto se for string
        if ($this->has('Desconto') && !empty($this->input('Desconto'))) {
            $desconto = $this->input('Desconto');
            
            if (is_string($desconto)) {
                $desconto = str_replace(['%', ' '], '', $desconto);
                $desconto = str_replace(',', '.', $desconto);
                
                $this->merge(['Desconto' => $desconto]);
            }
        }
    }
}