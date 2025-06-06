<?php
namespace App\Repositories\Auth;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Requests\AuthRequest\LoginRequest;


interface AuthRepositoryInterface
{
    public function Register(RegisterRequest $request);
    public function Login(LoginRequest $request);
    public function Logout($id_user);
    public function tokenExpired($token);
}