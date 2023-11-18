<?php

namespace App\Http\Requests\Painel;

use Illuminate\Foundation\Http\FormRequest;

class ProfessorFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $cpf = $this->request->filter('id')==null?'unique:professors':null;

        return [
            'nome'          =>      'required',
            //'nascimento'    =>      'required',
            'sexo'          =>      'required',
            //'email'         =>      'required',
            //'celular'       =>      'required',
            /*'cpf'           =>      "required|$cpf",
            'rg'            =>      'required',
            'rg_orgao'      =>      'required',
            'rg_uf'         =>      'required',
            'rg_data'       =>      'required',
            'cep'           =>      'required',
            'endereco'      =>      'required',
            'numero'        =>      'required|numeric',
            'bairro'        =>      'required',
            'uf'            =>      'required',
            'municipio'     =>      'required'*/
        ];
    }

}
