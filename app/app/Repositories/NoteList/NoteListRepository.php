<?php 
namespace App\Repositories\NoteList;
use App\Models\NoteList;
use App\Models\Response;
use Exception;

class NoteListRepository implements NoteListRepositoryInterface
{
    protected $noteLists, $response;

    public function __construct()
    {
        $this->noteLists    = new NoteList();
        $this->response     = new Response();
    }


    public function GetAll()
    {
        try {
            $data = $this->noteLists->GetAll();
            if(count($data) < 1){
                return $this->response->ResponseEmptyDataJson();
            } 
            return $this->response->ResponseJson(200, 'Success Get Note List Data', '', $data);
        } catch (Exception $e) {
            return $this->response->ResponseJson(500, 'Internal Server Error', $e->getMessage(), null);
        }
    }   
}
