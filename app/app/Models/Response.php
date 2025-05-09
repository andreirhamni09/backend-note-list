<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $status, $messages, $error, $data;
    public function __construct($status = 200, $messages = 'SUCCESS API REQUEST', $error = '', $data = [])
    {
        $this->status   = $status;
        $this->messages = $messages;
        $this->error    = $error;
        $this->data     = $data; 
    }
    public function ResponseJson($status, $messages, $error, $data){
        $res = [
            'status'    => $status,
            'messages'  => $messages,
            'error'     => $error,
            'data'      => $data
        ];
        return $res;
    }

    public function ResponseEmptyDataJson($status = 200, $messages = 'Empty Data', $error = '', $data = []){
        $res = [
            'status'    => $status,
            'messages'  => $messages,
            'error'     => $error,
            'data'      => $data
        ];
        return $res;
    }
}
