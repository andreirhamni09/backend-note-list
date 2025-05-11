<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Repositories\Auth\AuthRepositoryInterface;
class AuthController extends Controller
{
    protected $authRepositoryInterface;
    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }
    public function register(RegisterRequest $request) {
        $register = $this->authRepositoryInterface->Register($request);
        return response()->json($register);
    }
}
