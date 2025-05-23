<?php 
namespace App\Repositories\NoteList;

use App\Helpers\ResponseHelper;
use App\Http\Requests\NoteListRequest\AddNoteListRequest;
use App\Http\Requests\NoteListRequest\UpdateNoteListRequest;
use App\Models\NoteList;
use Illuminate\Support\Carbon;
use Exception;

class NoteListRepository implements NoteListRepositoryInterface
{
    protected $noteLists, $response;

    public function __construct()
    {
        $this->noteLists    = new NoteList();
        $this->response     = new ResponseHelper();
    }
    
    public function GetAll($id_user)
    {
        try {
            $data = $this->noteLists->GetAll($id_user);
            if(count($data->items()) < 1){
                return $this->response->empty("Data Note List Not Found", []);
            } 
            $paginate = [
                'current_page' => $data->currentPage(),
                'last_page' => $data->lastPage(),
                'total' => $data->total(),
            ];
            return $this->response->successPaginate('Success Get Note List Data', $data, $paginate);
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }   
    public function GetByIdNoteList($id_user, $id_note_lists)
    {
        try {
            $data = $this->noteLists->GetByIdNoteList($id_user, $id_note_lists);
            if($data === null){
                return $this->response->empty("Data Note List Not Found", []);
            } 
            return $this->response->success('Success Get Note List Data', $data);
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }       
    public function AddNoteList(AddNoteListRequest $request)
    {
        try {
            $created_at             = Carbon::now()->timezone('Asia/Jakarta');
            $id_user                = $request->id_user;
            $title_note_lists       = $request->title_note_lists;
            $deskripsi_note_lists   = $request->deskripsi_note_lists;
            $note_list              = $this->noteLists->AddNoteList($id_user, $title_note_lists, $deskripsi_note_lists, $created_at);
            $res                    = $this->response->success('Berhasil Manambahkan Note List Baru', $note_list);
            return $res;
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }       
    public function UpdateNoteList(UpdateNoteListRequest $request)
    {
        try {
            $updated_at             = Carbon::now();
            $id_note_lists          = $request->id_note_lists;
            $id_user                = $request->id_user;
            $title_note_lists       = $request->title_note_lists;
            $deskripsi_note_lists   = $request->deskripsi_note_lists;
            $this->noteLists->UpdateNoteList($id_note_lists, $id_user, $title_note_lists,$deskripsi_note_lists, $updated_at);
            $res                    = $this->response->success('Berhasil Mengubah Data Note List', null);
            return $res;
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }       

    public function DeleteNoteList($id_user, $id_note_lists)
    {
        try {
            $deleted_at             = Carbon::now()->timezone('Asia/Jakarta');
            $this->noteLists->DeleteNoteList($id_user, $id_note_lists, $deleted_at);            
            return $this->response->success('Berhasil Mengubah Data Note List', null);
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }   
}
