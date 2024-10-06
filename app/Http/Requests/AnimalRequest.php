<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AnimalRequest extends FormRequest
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
        return [
            'code'         => 'required|unique:animals,code|size:4',
            'milk'         => 'numeric',
            'food'         => 'required|numeric',
            'weight'       => 'required|numeric',
            'born'         => 'required|date',
            'shooted_down' => 'boolean'
        ];
    }

    /**
     * Get the validation rule message that apply to the request if it fails.
     *
     * @return array
     */
    public function messages() {
        return [
            'code.required' => 'O código de identificação do animal é obrigatório.',
            'code.unique'   => 'O código de identificação do animal deve ser único, e já existe outro animal com este código.',
            'code.size'     => 'O código de identificação do animal deve conter 4 dígitos.',
            'required'      => 'O campo :attribute é obrigatório.',
            'numeric'       => 'O campo :attribute deve ser do tipo numérico.',
            'date'          => 'O campo :attribute deve ser do tipo data.',
            'boolean'       => 'O campo :attribute deve ser do tipo booleano.'
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors();

        $response = response()->json([
            'message' => 'Foram encontrados um ou mais erros nas informações enviadas.',
            'errors' => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
