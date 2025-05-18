<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Repositories\Auth\AuthRepositoryInterface;
class AuthController extends Controller
{
    protected $authRepositoryInterface;

    public function __construct(AuthRepositoryInterface $authRepositoryInterface)
    {
        $this->authRepositoryInterface = $authRepositoryInterface;
    }
    public function register(RegisterRequest $request) {
        $register   = $this->authRepositoryInterface->Register($request);
        return response()->json($register);
    }
    public function login(LoginRequest $request){
        $login      = $this->authRepositoryInterface->Login($request);
        return response()->json($login);
    }
    public function logout($id_user){
        $logout      = $this->authRepositoryInterface->Logout($id_user);
        return response()->json($logout);
    }
}
