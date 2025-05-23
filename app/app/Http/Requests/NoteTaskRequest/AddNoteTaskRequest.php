<?php

namespace App\Http\Requests\NoteTaskRequest;

use App\Helpers\ResponseHelper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddNoteTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id_note_lists'      => 'required|integer|exists:note_lists,id_note_lists',
            'name_task'          => 'required|array',
            'name_task.*'        => 'required|string|min:3',
            'task_start_at'      => 'required|array',
            'task_start_at.*'    => 'required|date_format:Y-m-d H:i:s',
            'task_end_at'        => 'required|array',
            'task_end_at.*'      => 'required|date_format:Y-m-d H:i:s',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'id_note_lists.required'       => 'id_note_lists wajib diisi.',
            'id_note_lists.integer'        => 'id_note_lists harus berupa angka.',
            'id_note_lists.exists'         => 'id_note_lists tidak ditemukan di dalam sistem.',

            'name_task.required'           => 'Field name_task wajib diisi.',
            'name_task.array'              => 'Field name_task harus berupa array.',
            'name_task.*.required'         => 'Data name_task wajib diisi.',
            'name_task.*.string'           => 'Data name_task harus berupa teks.',
            'name_task.*.min'              => 'Tugas minimal terdiri dari 3 karakter.',

            'task_start_at.required'       => 'Field task_start_at wajib diisi.',
            'task_start_at.array'          => 'Field task_start_at harus berupa array.',
            'task_start_at.*.required'     => 'Data task_start_at wajib diisi.',
            'task_start_at.*.date_format'  => 'Format task_start_at harus "Y-m-d H:i:s", contoh: 2025-05-22 13:45:00.',

            'task_end_at.required'         => 'Field task_end_at wajib diisi.',
            'task_end_at.array'            => 'Field task_end_at harus berupa array.',
            'task_end_at.*.required'       => 'Data task_end_at wajib diisi.',
            'task_end_at.*.date_format'    => 'Format task_end_at harus "Y-m-d H:i:s", contoh: 2025-05-22 13:45:00.',
        ];
    }

    /**
     * Add custom logic after validation passes standard rules.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $starts = $this->input('task_start_at', []);
            $ends   = $this->input('task_end_at', []);
            $tasks  = $this->input('name_task', []);

            $count = min(count($starts), count($ends), count($tasks));

            // Validasi jumlah array harus sama
            if (count($starts) !== count($ends) || count($starts) !== count($tasks)) {
                $validator->errors()->add('task_array', 'Jumlah item pada name_task, task_start_at, dan task_end_at harus sama.');
                return;
            }

            // Validasi waktu selesai harus setelah waktu mulai
            for ($i = 0; $i < $count; $i++) {
                $start = $starts[$i];
                $end   = $ends[$i];

                if (strtotime($end) <= strtotime($start)) {
                    $validator->errors()->add("task_end_at.$i", "Waktu selesai harus setelah waktu mulai untuk task ke-" . ($i + 1) . ".");
                }
            }
        });
    }

    /**
     * Override default failed validation to return JSON response.
     */
    protected function failedValidation(Validator $validator)
    {
        $errors      = $validator->errors();
        $input       = $this->all();
        $responseApi = new ResponseHelper();
        $res         = $responseApi->validationError("Add Note Task Gagal", $errors->toArray(), $input);

        throw new HttpResponseException(response()->json($res));
    }
}
