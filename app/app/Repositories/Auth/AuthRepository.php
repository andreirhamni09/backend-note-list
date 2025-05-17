<?php 
namespace App\Repositories\Auth;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Models\Response;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use App\Models\Token;

class AuthRepository implements AuthRepositoryInterface
{
    protected $response, $users, $tokens;

    public function __construct()
    {
        $this->response     = new Response();
        $this->users        = new User();
        $this->tokens       = new Token();
    }
    public function Register(RegisterRequest $request) {
        try {
            $created_at = Carbon::now();
            $nama_user      = $request->nama_user;
            $email_user     = $request->email_user;
            $password_user  = Hash::make($request->password_user);
            $created_at     = $created_at;
            $user = $this->users->Register($nama_user, $email_user, $password_user, $created_at);
            $res            = $this->response->ResponseSuccessJson('Berhasil register', $user);
            return $res;
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }
    public function Login(LoginRequest $request) {
        try {
            $email_user     = $request->email_user;
            $user           = $this->users->Login($email_user);
            if(Hash::check($request->password_user, $user->password_user)) {
                $token              = $this->tokens->CreateToken($user->password_user);
                $expired            = Carbon::now()->addHours(2)->timezone('Asia/Jakarta');
                $created_tokens     = $this->tokens->InsertToken($user->id_user, $token, $expired);
                $res                = $this->response->ResponseSuccessJson('Berhasil Login', $created_tokens);
            } else {
                $res            = $this->response->ResponseEmptyJson('Password yang ada masukan tidak cocok');
            }
            return $res;
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }
}
