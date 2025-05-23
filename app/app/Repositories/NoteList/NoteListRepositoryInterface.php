<?php
namespace App\Repositories\NoteList;
use App\Http\Requests\NoteListRequest\AddNoteListRequest;
use App\Http\Requests\NoteListRequest\UpdateNoteListRequest;
interface NoteListRepositoryInterface
{
    public function GetAll($id_user);
    public function GetByIdNoteList($id_user, $id_note_lists);
    public function AddNoteList(AddNoteListRequest $request);
    public function UpdateNoteList(UpdateNoteListRequest $request);
    public function DeleteNoteList($id_user, $id_note_lists);
}