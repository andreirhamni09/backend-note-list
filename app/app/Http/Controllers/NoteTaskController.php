<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\NoteTaskRequest\UpdateNoteTaskRequest;
use App\Http\Requests\NoteTaskRequest\AddNoteTaskRequest;
use App\Repositories\NoteTask\NoteTaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class NoteTaskController extends Controller
{
    protected $i_noteTask;
    public function __construct(NoteTaskRepositoryInterface $noteTaskRepositoryInterface) {
        $this->i_noteTask = $noteTaskRepositoryInterface;
    }

    public function GetAll($id_note_lists, Request $request) {
        $page = $request->query('page', 1);

        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $getAll = $this->i_noteTask->GetAll($id_note_lists);
        return response()->json($getAll);
    }

    public function AddNoteTask(AddNoteTaskRequest $request) {
        $add = $this->i_noteTask->AddNoteTask($request);
        return response()->json($add); 
    }

    public function GetById($id_note_task) {
        $getById = $this->i_noteTask->GetById($id_note_task);
        return response()->json($getById);  
    }

    public function UpdateNoteTask($id_note_task, UpdateNoteTaskRequest $request) {
        $update = $this->i_noteTask->UpdateNoteTask($id_note_task, $request);
        return response()->json($update);
    }
    public function UpdateStatusNoteTask($id_note_task, Request $request) {
        $status = $request->input('status_task');
        $updateStatus = $this->i_noteTask->UpdateStatusNoteTask($id_note_task, $status);
        return response()->json($updateStatus);
    }
    public function DeleteTask($id_note_task) {
        $delete = $this->i_noteTask->DeleteTask($id_note_task);
        return response()->json($delete);
    }
}
