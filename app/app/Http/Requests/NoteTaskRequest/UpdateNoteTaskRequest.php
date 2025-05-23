<?php

namespace App\Http\Requests\NoteTaskRequest;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateNoteTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    
    public function rules(): array
    {
        return [
            'name_task'                 =>'required|string|min:3',
            'task_start_at'             =>'required|date_format:Y-m-d H:i:s',
            'task_end_at'               =>'required|date_format:Y-m-d H:i:s|after:task_start_at',
        ];
    }

    public function messages(): array
    {
        return [
            'name_task.required'            => 'title_note_lists wajib diisi.',
            'name_task.string'              => 'format title_note_lists wajib diisi dengan teks.',
            'name_task.min'                 => 'title_note_lists diidi minimal 3 karakter.',
            'task_start_at.required'        => 'Data task_start_at wajib diisi.',
            'task_start_at.date_format'     => 'Format task_start_at harus "Y-m-d H:i:s", contoh: 2025-05-22 13:45:00.',
            'task_end_at.required'          => 'Data task_end_at wajib diisi.',
            'task_end_at.date_format'       => 'Format task_end_at harus "Y-m-d H:i:s", contoh: 2025-05-22 13:45:00.',
            'task_end_at.after'             => 'Waktu task_end_at harus setelah waktu task_start_at',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors         = $validator->errors();
        $input          = $this->all();
        $responseApi    = new ResponseHelper();
        $res            = $responseApi->validationError("Gagal Update Data Note Task", $errors, $input);
        throw new HttpResponseException(response()->json($res));
    }
}
