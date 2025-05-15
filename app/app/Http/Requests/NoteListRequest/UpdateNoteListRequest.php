<?php

namespace App\Http\Requests\NoteListRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\Response;

class UpdateNoteListRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'id_note_lists'             => 'required|integer|exists:note_lists',
            'id_user'                   => 'required|integer|exists:users', 
            'title_note_lists'          => 'required|string|min:3',
            'deskripsi_note_lists'      => 'required|string|min:3'            
        ];
    }

    public function messages(): array
    {
        return [
            'id_note_lists.required'        => 'id_note_lists wajib diisi.',
            'id_note_lists.integer'         => 'id_note_lists wajib diisi dengan id note list (Angka).',
            'id_note_lists.exists'          => 'id_note_lists tidak ditemukan didalam sistem.',
            'id_user.required'              => 'id_user wajib diisi.',
            'id_user.integer'               => 'id_user wajib diisi dengan id user (Angka).',
            'id_user.exists'                => 'id_user tidak ditemukan didalam sistem.',
            'title_note_lists.required'     => 'title_note_lists wajib diisi.',
            'title_note_lists.string'       => 'format title_note_lists wajib diisi dengan teks.',
            'title_note_lists.min'          => 'title_note_lists diidi minimal 3 karakter.',
            'deskripsi_note_lists.required' => 'deskripsi_note_lists wajib diisi.',
            'deskripsi_note_lists.string'   => 'format deskripsi_note_lists wajib diisi dengan teks.',
            'deskripsi_note_lists.min'      => 'deskripsi_note_lists wajib diisi minimal 3 karakter.'
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors         = $validator->errors();
        $input          = $this->all();
        $responseApi    = new Response();
        $res            = $responseApi->ResponseUnvalidatedJson("Request update data note list gagal", $errors, $input);
        throw new HttpResponseException(response()->json($res));
    }
}
