<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NoteTask extends Model
{
    public function GetAll($id_note_lists) {
        $noteTask = DB::table('note_list_tasks')
        ->where('note_list_tasks.id_note_lists', '=', $id_note_lists)
        ->where('deleted_at', '=', null)
        ->paginate(10);
        return $noteTask;
    }
    public function AddNoteTask($id_note_lists,$name_task,$task_start_at,$task_end_at,$status_task,$created_at) {
        $data = [];
        for ($i=0; $i < count($name_task); $i++) { 
            $insertedData = [
                "id_note_lists"     => $id_note_lists,
                "name_task"         => $name_task[$i],
                "task_start_at"     => $task_start_at[$i],
                "task_end_at"       => $task_end_at[$i],
                "status_task"       => $status_task,
                "created_at"        => $created_at,
            ];
            array_push($data, $insertedData);
        }
        DB::table('note_list_tasks')
        ->insert($data);
        return $data;        
    }
    public function GetById($id_note_task) {
        $data = DB::table('note_list_tasks')
        ->where('id_note_list_task', '=', $id_note_task)
        ->first();
        return $data;
    }

    public function UpdateNoteTask($id_note_task, $name_task, $task_start_at, $task_end_at) {
        DB::table('note_list_tasks')
        ->where('id_note_list_task', '=', $id_note_task)
        ->update([
            'name_task'         =>$name_task,
            'task_start_at'     =>$task_start_at,
            'task_end_at'       =>$task_end_at
        ]);
        $data = [
            'id_note_task'      => $id_note_task, 
            'name_task'         => $name_task,
            'task_start_at'     => $task_start_at,
            'task_end_at'       => $task_end_at
        ];
        return $data;
        // code
    }
    public function UpdateStatusNoteTask($id_note_task, $status) {
        DB::table('note_list_tasks')
        ->where('id_note_list_task', '=', $id_note_task)
        ->update(['status_task' => $status]);
    }

    public function DeleteTask($id_note_task, $deleted_at) {
        DB::table('note_list_tasks')
        ->where('id_note_list_task', '=', $id_note_task)
        ->update(['deleted_at' => $deleted_at]);
    }
}
