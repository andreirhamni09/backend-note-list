<?php
namespace App\Repositories\NoteTask;
use App\Http\Requests\NoteTaskRequest\UpdateNoteTaskRequest;
use App\Http\Requests\NoteTaskRequest\AddNoteTaskRequest;

interface NoteTaskRepositoryInterface
{
    public function GetAll($id_note_lists);
    public function AddNoteTask(AddNoteTaskRequest $request);
    public function UpdateNoteTask($id_note_task, UpdateNoteTaskRequest $request);
    public function GetById($id_note_task);
    public function UpdateStatusNoteTask($id_note_task, $status);
    public function DeleteTask($id_note_task);
}