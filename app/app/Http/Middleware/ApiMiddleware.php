<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use App\Models\Token;
use Illuminate\Support\Carbon;

class ApiMiddleware
{
    protected $m_response, $m_token;

    public function __construct() {
        $this->m_response = new ResponseHelper();
        $this->m_token    = new Token();
    }

    public function handle(Request $request, Closure $next)
    {
        $authHeader         = $request->header('Authorization');
        if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
            $response       = $this->m_response->unauthorized('Akses API Membutuhkan Token');
            return response()->json($response);
        }
        $token_str          = substr($authHeader, 7);
        # 1. Cek Token Apakah Ada Atau Belum
        $getTokenByToken    = $this->m_token->GetTokenByToken($token_str);
        if($getTokenByToken !== null) { # Jika Ada 
            # 2. Cek Apakah Token Expired Atau Tidak
            $cekTokenExpired = Carbon::parse($getTokenByToken->expired)->isPast();
            if($cekTokenExpired) {
                $response   = $this->m_response->unauthorized('Mohon Melakukan Login Ulang Mendapatkan Akses API Token (Token Sudah Expired)');
                return response()->json($response);
            } else {
                return $next($request);
            }
        } else { # Jika Tidak Ada
            $response   = $this->m_response->unauthorized('Mohon Melakukan Login Untuk Mendapatkan Akses API Token');
            return response()->json($response); 
        }
    }
}
