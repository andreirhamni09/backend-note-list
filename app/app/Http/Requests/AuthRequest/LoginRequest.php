<?php

namespace App\Http\Requests\AuthRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Response;

class LoginRequest extends FormRequest
{
     public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'email_user'        => 'required|string|email|max:255|exists:users',
            'password_user'     => 'required|string|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'email_user.max'            => 'Email wajib diisi.',
            'email_user.required'       => 'Email wajib diisi.',
            'email_user.email'          => 'Format email tidak valid.',
            'email_user.exists'         => 'Email tidak ditemukan.',
            'password_user.required'    => 'Password wajib diisi.',
            'password_user.min'         => 'Password minimal 6 karakter.'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors         = $validator->errors();
        $input          = $this->all();
        $responseApi    = new Response();
        $res            = $responseApi->ResponseUnvalidatedJson("Login gagal", $errors, $input);
        throw new HttpResponseException(response()->json($res));
    }
}
