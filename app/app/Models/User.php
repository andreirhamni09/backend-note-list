<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Connection;

class User extends Model
{
    public function Register($nama_user, $email_user, $password_user, $created_at) {
        $id = DB::table('users')->insertGetId([
            'nama_user'         => $nama_user,
            'email_user'        => $email_user,
            'password_user'     => $password_user,
            'created_at'        => $created_at
        ]);
        $user = DB::table('users')->where('id_user', $id)->first();
        return $user;
    }

    public function Login($email_user) {
        $user = DB::table('users')
        ->where('email_user', '=', $email_user)
        ->first();
        return $user;
    }
}
