<?php 
namespace App\Repositories\NoteTask;

use App\Helpers\ResponseHelper;
use App\Models\NoteTask;
use Exception;
use App\Http\Requests\NoteTaskRequest\AddNoteTaskRequest;
use Illuminate\Support\Carbon;
use App\Http\Requests\NoteTaskRequest\UpdateNoteTaskRequest;

class NoteTaskRepository implements NoteTaskRepositoryInterface
{
    protected $m_noteTask, $h_response;

    public function __construct() {
        $this->m_noteTask   = new NoteTask();
        $this->h_response   = new ResponseHelper();
    }

    public function GetAll($id_note_lists) {
        try {
            $noteTask = $this->m_noteTask->GetAll($id_note_lists);
            if(count($noteTask->items()) > 0) {
                $paginate = [
                    'current_page' => $noteTask->currentPage(),
                    'last_page' => $noteTask->lastPage(),
                    'total' => $noteTask->total(),
                ];
                return $this->h_response->successPaginate('Success Get Note List Data', $noteTask, $paginate);
            } else {
                return $this->h_response->empty('Data Not Found', null);
            }
        } catch (Exception $e) {
            return $this->h_response->internalError($e->getMessage());
        }
    }
    public function AddNoteTask(AddNoteTaskRequest $request) {
        try {
            $id_note_lists      = $request->input('id_note_lists');                
            $name_task          = $request->input('name_task');    
            $task_start_at      = $request->input('task_start_at');    
            $task_end_at        = $request->input('task_end_at');    
            $status_task        = "false";    
            $created_at         = Carbon::now();
            $add = $this->m_noteTask->AddNoteTask($id_note_lists,$name_task,$task_start_at,$task_end_at,$status_task,$created_at);
            return $this->h_response->success('Berhasil Menambahkan Task Note List', $add);
        } catch (Exception $e) {
            return $this->h_response->internalError($e->getMessage());
        }
    }
    public function GetById($id_note_task) {
        try {
            $getById    = $this->m_noteTask->GetById($id_note_task);
            $res        = "";
            if($getById == null) {
                $res    = $this->h_response->empty('Not Found', []);
            } else {
                $res    = $this->h_response->success('Data Note List Task', $getById);
            }
            return $res;
        } catch (Exception $e) {
            return $this->h_response->internalError($e->getMessage());
        }
    }

    public function UpdateNoteTask($id_note_task, UpdateNoteTaskRequest $request) {
        try {
            $name_task          = $request->input('name_task');
            $task_start_at      = $request->input('task_start_at');
            $task_end_at        = $request->input('task_end_at');
            $update = $this->m_noteTask->UpdateNoteTask($id_note_task, $name_task, $task_start_at, $task_end_at);
            return $this->h_response->success('Data Berhasil di Update', $update);
        } catch (Exception $e) {
            return $this->h_response->internalError($e->getMessage());
        }
    }
    public function UpdateStatusNoteTask($id_note_task, $status) {
        try {
            $this->m_noteTask->UpdateStatusNoteTask($id_note_task, $status);
            $update = $this->h_response->success('Task Telah Diselesaikan', null);
            return $update;
        } catch (Exception $e) {
            return $this->h_response->internalError($e->getMessage());
        }
    }
    public function DeleteTask($id_note_task) {
        try {
            $deleted_at         = Carbon::now();
            $this->m_noteTask->DeleteTask($id_note_task, $deleted_at);
            $delete = $this->h_response->success('Task Telah Dihapus', null);
            return $delete;
        } catch (Exception $e) {
            return $this->h_response->internalError($e->getMessage());
        }
    }
}
