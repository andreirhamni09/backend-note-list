<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class User extends Model
{
    public function Register($nama_user, $email_user, $password_user, $created_at) {
        DB::table('users')->insert([
            'nama_user'         => $nama_user,
            'email_user'        => $email_user,
            'password_user'     => $password_user,
            'created_at'        => $created_at
        ]);
    }
}
