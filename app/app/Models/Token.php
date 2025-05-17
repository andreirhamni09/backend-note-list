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

    public function InsertToken($id_user, $token, $expired) {
        $getTokenById = $this->GetTokenById($id_user);
        if($getTokenById == null) {
            $id = DB::table('tokens')->insertGetId([
                'id_user'        => $id_user,
                'token'          => $token,
                'expired'        => $expired
            ]);
            $tokens = DB::table('tokens')
            ->join('users', 'users.id_user', '=', 'tokens.id_user')
            ->where('tokens.id_token', '=', $id)
            ->first();
            return $tokens;
        } else {
            $expired_tokens = Carbon::parse($getTokenById->expired)->isPast();
            if($expired_tokens) {
                $deleteToken = $this->DeleteTokens($id_user);
                if($deleteToken) {
                    $id = DB::table('tokens')->insertGetId([
                        'id_user'        => $id_user,
                        'token'          => $token,
                        'expired'        => $expired
                    ]);
                    $tokens = DB::table('tokens')
                    ->join('users', 'users.id_user', '=', 'tokens.id_user')
                    ->where('tokens.id_token', '=', $id)
                    ->first();
                    return $tokens;
                }
            } else {
                return $getTokenById;
            }
        }
    }

    public function GetTokenById($id_user) {
        $getToken = DB::table('tokens')
        ->join('users', 'users.id_user', '=', 'tokens.id_user')
        ->where('tokens.id_user', '=', $id_user)
        ->first();
        return $getToken;
    }

    public function DeleteTokens($id_user) {
        $deleteToken = DB::table('tokens')
        ->where('tokens.id_user', '=', $id_user)
        ->delete();
        return $deleteToken;
    }

}
