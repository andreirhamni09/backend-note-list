<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Response;
use Exception;

class PublicFunctionController extends Controller
{
    protected $response;

    public function __construct()
    {
        $this->response = new Response();
    }

    public function CheckConnection() {
        try {
            $dbconnect  = DB::connection()->getPDO();
            $dbname     = DB::connection()->getDatabaseName();
            $messages   = "Connected successfully to the database. Database name is :".$dbname;
            $res        = $this->response->ResponseSuccessJson($messages, []);
            return $res;
        } catch(Exception $e) {
            $messages   = "Error in connecting to the database :". $e->getMessage();
            $res        = $this->response->ResponseInternalServerErrorJson($messages);
            return $res;
        }
    }
}
