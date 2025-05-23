<?php

namespace App\Helpers;

use Symfony\Component\HttpFoundation\Response as Http;

class ResponseHelper
{
    public function success(string $message = 'Success', $data)
    {
        $response   =   [
            'status'   => Http::HTTP_OK,
            'messages' => $message,
            'error'    => '',
            'data'     => $data,
        ];
        return $response;
    }
    public function successPaginate(string $message = 'Success', $data, $paginate)
    {
        $response   =   [
            'status'    => Http::HTTP_OK,
            'messages'  => $message,
            'error'     => '',
            'data'      => $data,
            'paginate'  => $paginate
        ];
        return $response;
    }

    public function empty(string $message = 'No Content', $data)
    {
        $response   = [
            'status'   => Http::HTTP_NO_CONTENT,
            'messages' => $message,
            'error'    => '',
            'data'     => $data,
        ];
        return $response;
    }

    public function internalError(string $error = 'Internal Server Error')
    {
        $response       = [
            'status'   => Http::HTTP_INTERNAL_SERVER_ERROR,
            'messages' => 'Internal Server Error',
            'error'    => $error,
            'data'     => null,
        ];
        return $response;
    }

    public function validationError(string $message = 'Validation Error', $errors, $data)
    {
        $response   = [
            'status'   => Http::HTTP_UNPROCESSABLE_ENTITY,
            'messages' => $message,
            'error'    => $errors,
            'data'     => $data,
        ];
        return $response;
    }

    public function unauthorized(string $message = 'Unauthorized')
    {
        $response       = [
            'status'   => Http::HTTP_UNAUTHORIZED,
            'messages' => $message,
            'error'    => '',
            'data'     => [],
        ];
        return $response;
    }
}
