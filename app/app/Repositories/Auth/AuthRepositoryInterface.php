<?php
namespace App\Repositories\Auth;
use App\Http\Requests\RegisterRequest;


interface AuthRepositoryInterface
{
    public function Register(RegisterRequest $request);
}