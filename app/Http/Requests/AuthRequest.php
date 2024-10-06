<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthRequest extends FormRequest
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
            'name' => 'required|max: 20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4'
        ];
    }

    /**
     * Get the validation rule message that apply to the request if it fails.
     *
     * @return array
     */
    public function messages() {
        return [
            "required"        => "O campo :attribute é obrigatório.",
            "name.max" => "O campo name deve conter no máximo 20 dígitos.",
            "email"           => "O campo :attribute deve ser um email válido.",
            "unique"          => "O campo :attribute deve ser único, e já existe um usuário com este :attribute",
            "password"        => "O campo senha deve conter no mínimo 4 dígitos.",
        ];
    }

    protected function failedValidation(Validator $validator) {
        $errors = $validator->errors();

        $response = response()->json([
            "message" => "Foram encontrados um ou mais erros nas informações enviadas.",
            "errors" => $errors->messages(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
