<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\NoteListRequest\AddNoteListRequest;
use App\Http\Requests\NoteListRequest\UpdateNoteListRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

use App\Repositories\NoteList\NoteListRepositoryInterface;

class NoteListController extends Controller
{
    protected $noteListRepositoryInterface;

    public function __construct(NoteListRepositoryInterface $noteListRepositoryInterface)
    {
        $this->noteListRepositoryInterface = $noteListRepositoryInterface;        
    }
    
    public function GetAll($id_user, Request $request)
    {
        $page = $request->query('page', 1);
          // Set halaman aktif secara manual
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        return response()->json($this->noteListRepositoryInterface->GetAll($id_user));
    }

    public function GetByIdNoteList($id_user, $id_note_lists)
    {
        return response()->json($this->noteListRepositoryInterface->GetByIdNoteList($id_user, $id_note_lists));
    }

    public function AddNoteList(AddNoteListRequest $request){
        return response()->json($this->noteListRepositoryInterface->AddNoteList($request));
    }

    public function UpdateNoteList(UpdateNoteListRequest $request){
        return response()->json($this->noteListRepositoryInterface->UpdateNoteList($request));
    }    
    
    public function DeleteNoteList($id_user, $id_note_lists){
        return response()->json($this->noteListRepositoryInterface->DeleteNoteList($id_user, $id_note_lists));
    }    
}
