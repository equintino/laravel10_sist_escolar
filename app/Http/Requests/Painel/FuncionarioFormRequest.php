<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $cpf = $this->request->filter('id')==null?'unique:funcionarios':null;
        return [
            'nome'          =>      'required',
            //'nascimento'    =>      'required',
            'sexo'          =>      'required',
            //'email'         =>      'required',
            /*'telefone'      =>      'required',
            'celular'       =>      'required',
            'cpf'           =>      "required|$cpf",
            'rg'            =>      'required',
            'rg_orgao'      =>      'required',
            'rg_uf'         =>      'required',
            'rg_data'       =>      'required',
            'cep'           =>      'required',
            'endereco'      =>      'required',
            'numero'        =>      'required|numeric',
            'bairro'        =>      'required',
            'uf'            =>      'required',
            'municipio'     =>      'required',*/
            /*'setor'         =>      'required',
            'funcao'        =>      'required',
            'admissao'      =>      'required',
            'entrada'       =>      'required',
            'saida'         =>      'required'*/
        ];
    }

}
