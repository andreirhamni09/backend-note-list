<?php 
namespace App\Repositories\NoteList;

use App\Http\Requests\NoteListRequest\AddNoteListRequest;
use App\Http\Requests\NoteListRequest\UpdateNoteListRequest;
use App\Models\NoteList;
use App\Models\Response;
use Illuminate\Support\Carbon;
use Exception;

class NoteListRepository implements NoteListRepositoryInterface
{
    protected $noteLists, $response;

    public function __construct()
    {
        $this->noteLists    = new NoteList();
        $this->response     = new Response();
    }
    
    public function GetAll($id_user)
    {
        try {
            $data = $this->noteLists->GetAll($id_user);
            if(count($data) < 1){
                return $this->response->ResponseEmptyJson("Data Note List Not Found");
            } 
            return $this->response->ResponseSuccessJson('Success Get Note List Data', $data);
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }   
    public function GetByIdNoteList($id_user, $id_note_lists)
    {
        try {
            $data = $this->noteLists->GetByIdNoteList($id_user, $id_note_lists);
            if(count($data) < 1){
                return $this->response->ResponseEmptyJson("Data Note List Not Found");
            } 
            return $this->response->ResponseSuccessJson('Success Get Note List Data', $data);
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }       
    public function AddNoteList(AddNoteListRequest $request)
    {
        try {
            $created_at             = Carbon::now()->timezone('Asia/Jakarta');
            $id_user                = $request->id_user;
            $title_note_lists       = $request->title_note_lists;
            $deskripsi_note_lists   = $request->deskripsi_note_lists;
            $this->noteLists->AddNoteList($id_user, $title_note_lists, $deskripsi_note_lists, $created_at);
            $res                    = $this->response->ResponseSuccessJson('Berhasil Manambahkan Note List Baru', null);
            return $res;
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }       
    public function UpdateNoteList(UpdateNoteListRequest $request)
    {
        try {
            $updated_at             = Carbon::now()->timezone('Asia/Jakarta');
            $id_note_lists          = $request->id_note_lists;
            $id_user                = $request->id_user;
            $title_note_lists       = $request->title_note_lists;
            $deskripsi_note_lists   = $request->deskripsi_note_lists;
            $this->noteLists->UpdateNoteList($id_note_lists, $id_user, $title_note_lists,$deskripsi_note_lists, $updated_at);
            $res                    = $this->response->ResponseSuccessJson('Berhasil Mengubah Data Note List', null);
            return $res;
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }       
}
