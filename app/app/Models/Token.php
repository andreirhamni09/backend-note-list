<?php

namespace App\Models;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class Token extends Model
{
    public function CreateToken($str_password) {
        $token = hash('sha256', $str_password);
        return $token;
    }

    public function InsertTokenLogin($id_user, $token, $expired) {
        $id = DB::table('tokens')->insertGetId([
                'id_user'        => $id_user,
                'token'          => $token,
                'expired'        => $expired
            ]);
        $tokens = DB::table('tokens')
        ->join('users', 'users.id_user', '=', 'tokens.id_user')
        ->select(
            'tokens.id_user      as id_user',
            'tokens.token        as token',
            'tokens.expired      as expired',
            'users.email_user    as email_user',
            'users.password_user as password_user',
            'users.nama_user     as nama_user'
        )
        ->where('tokens.id_token', '=', $id)
        ->first();
        return $tokens;
    }

    public function ReInsertTokenLogin($id_user, $token, $expired) {
        $this->DeleteTokens($id_user);
        $reInsertTokenLogin = $this->InsertTokenLogin($id_user, $token, $expired);
        return $reInsertTokenLogin;        
    }


    public function GetTokenByIdUser($id_user) {
        $getToken = DB::table('tokens')
        ->join('users', 'users.id_user', '=', 'tokens.id_user')
        ->select(
            'tokens.id_user      as id_user',
            'tokens.token        as token',
            'tokens.expired      as expired',
            'users.email_user    as email_user',
            'users.password_user as password_user',
            'users.nama_user     as nama_user'
        )
        ->where('tokens.id_user', '=', $id_user)
        ->first();
        return $getToken;
    }

    public function GetTokenByToken($token) {
        $getToken = DB::table('tokens')
        ->join('users', 'users.id_user', '=', 'tokens.id_user')
        ->select(
            'tokens.id_user      as id_user',
            'tokens.token        as token',
            'tokens.expired      as expired',
            'users.email_user    as email_user',
            'users.password_user as password_user',
            'users.nama_user     as nama_user'
        )
        ->where('tokens.token', '=', $token)
        ->first();
        return $getToken;
    }
    public function DeleteTokens($id_user) {
        DB::table('tokens')
        ->where('tokens.id_user', '=', $id_user)
        ->delete();
    }
}
