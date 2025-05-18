<?php

namespace App\Models;

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

# -- Response Success
    private function ResponseSuccess($status = 200, $error = '') {
        $success    = [
            'status'    => $status,
            'error'     => $error
        ];
        return $success;
    }
    public function ResponseSuccessJson($messages, $data){
        $success    = $this->ResponseSuccess();
        $res = [
            'status'    => $success['status'],
            'messages'  => $messages,
            'error'     => $success['error'],
            'data'      => $data
        ];
        return $res;
    }
# -- Response Success

# -- Response Empty Data
    private function ResponseEmpty($status = 204, $error = '', $data = []) {
        $empty = [
            'status'    => $status,
            'error'     => $error,
            'data'      => $data
        ];
        return $empty;
    }

    public function ResponseEmptyJson($messages){
        $empty = $this->ResponseEmpty();
        $res = [
            'status'    => $empty['status'],
            'messages'  => $messages,
            'error'     => $empty['error'],
            'data'      => $empty['data']
        ];
        return $res;
    }
# -- Response Empty Data

# -- Response Internal Server Error
    private function ResponseInternalServerError($status = 500, $messages = 'Internal Server Error', $data = null) {
        $internalServerError = [
            'status'    => $status,
            'messages'  => $messages,
            'data'      => $data
        ];
        return $internalServerError;
    }

    public function ResponseInternalServerErrorJson($error) {
        $internalServerError = $this->ResponseInternalServerError();
        $res = [
            'status'      => $internalServerError['status'],
            'messages'    => $internalServerError['messages'],
            'error'       => $error,
            'data'        => $internalServerError['data']
        ];
        return $res;
    }
# -- Response Internal Server Error

# -- Response Validate Error
    private function ResponseUnvalidated($status = 422) {
        $internalServerError = [
            'status'    => $status
        ];
        return $internalServerError;
    }

    public function ResponseUnvalidatedJson($messages, $error, $data) {
        $unvalidated    = $this->ResponseUnvalidated();
        $res = [
            'status'      => $unvalidated['status'],
            'messages'    => $messages,
            'error'       => $error,
            'data'        => $data
        ];
        return $res;
    }
# -- Response Validate Error

# -- Response Unauthorized
    public function ResponseUnauthorized($status = 401) {
        $unauthorized   = [
            'status'    => $status
        ];
        return $unauthorized;
    }
    public function ResponseUnauthorizedJson($messages) {
        $unauthorized   = $this->ResponseUnauthorized();
        $res = [
            'status'      => $unauthorized['status'],
            'messages'    => $messages,
            'error'       => '',
            'data'        => []
        ];
        return $res;
    }
# -- Response Unauthorized
}
