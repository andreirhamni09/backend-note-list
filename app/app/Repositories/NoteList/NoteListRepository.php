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
                return $this->response->ResponseEmptyJson("Data Note List Empty");
            } 
            return $this->response->ResponseSuccessJson('Success Get Note List Data', $data);
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }   
}
