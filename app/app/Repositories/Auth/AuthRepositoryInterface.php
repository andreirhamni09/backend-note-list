<?php
namespace App\Repositories\Auth;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Requests\AuthRequest\LoginRequest;


interface AuthRepositoryInterface
{
    public function Register(RegisterRequest $request);
    public function Login(LoginRequest $request);
}