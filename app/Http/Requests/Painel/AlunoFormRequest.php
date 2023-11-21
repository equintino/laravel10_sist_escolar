<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class AlunoFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nome'          => 'required',
            'nascimento'    => 'required',
            'sexo'          => 'required',
            /*'pai'           => 'required',
            'mae'           => 'required',
            'telefone'      => 'required',
            'cep'           => 'required',
            'endereco'      => 'required',
            'numero'        => 'required',
            'bairro'        => 'required',
            'uf'            => 'required',
            'municipio'     => 'required',*/
            // 'turno'         => 'required',
            'turma_id'         => 'required'
        ];
    }
}
