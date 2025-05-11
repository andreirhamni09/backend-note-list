<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Response;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'nama_user'         => 'required|string|min:3|max:100',
            'email_user'        => 'required|string|email|max:255|unique:users',
            'password_user'     => 'required|string|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'nama_user.required'        => 'Nama wajib diisi.',
            'nama_user.min'             => 'Nama wajib minimal 3 karakter.',
            'nama_user.max'             => 'Nama wajib maksimal 100 karakter.',
            'email_user.max'            => 'Email wajib diisi.',
            'email_user.required'       => 'Email wajib diisi.',
            'email_user.email'          => 'Format email tidak valid.',
            'email_user.unique'         => 'Email sudah terdaftar.',
            'password_user.required'    => 'Password wajib diisi.',
            'password_user.min'         => 'Password minimal 6 karakter.'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors         = $validator->errors();
        $input          = $this->all();
        $responseApi    = new Response();
        $res            = $responseApi->ResponseUnvalidatedJson("Request register gagal", $errors, $input);
        throw new HttpResponseException(response()->json($res));
    }
}
