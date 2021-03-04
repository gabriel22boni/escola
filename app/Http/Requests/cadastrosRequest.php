<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class cadastrosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = auth()->user()->id;

        return [
            'bairro'    => ['required'],     
            'cidade'    => ['required'],     
            'cnpj'      => ['required'], 
            'endereco'  => ['required'],   
            'estado'    => ['required'],     
            'fnome'     => ['required'],     
            'limite'    => ['required'],     
            'nome'      => ['required'], 
            'numero'    => ['required'],     
            'cpf'       => ['required'], 
            'cep'       => ['required'], 
            'email'     => ['required'],     
            'password'  => ['required'],  
            'fone'      => ['required'], 
            'cel'       => ['required'], 
            'razsoc'    => ['required'],     
            'pessoa'    => ['required']
        ];
    }
}
