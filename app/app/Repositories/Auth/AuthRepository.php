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
    public function CreateTokenLogin($password_user) {
        $token = hash('sha256', $password_user);
        return $token;
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
            # Pengecekan Apakah Password Yang Dimasukan Salah atau tidak
            if(Hash::check($request->password_user, $user->password_user)) {
                $id_user                = $user->id_user;
                $token                  = $this->CreateTokenLogin($user->password_user);
                $expired                = Carbon::now()->addHours(2);
                $getTokenByIdUser       = $this->tokens->GetTokenByIdUser($user->id_user);
                # Pengecekan Apakah Token Sudah Ada Atau belum disistem
                if($getTokenByIdUser !== null) { # Jika Token Sudah Ada (Cek Token Expired)
                    $cekTokenExistExpired = Carbon::parse($getTokenByIdUser->expired)->isPast();
                    #Pengecekan apakah token yang didalam sistem sudah expired atau belum
                    if($cekTokenExistExpired) { # Jika Token Sudah Expired   
                        $reInsertTokenLogin        = $this->tokens->ReInsertTokenLogin($id_user, $token, $expired);
                        $response                       = $this->response->ResponseSuccessJson('Login Succesfull', $reInsertTokenLogin);
                    } else {
                        $response                = $this->response->ResponseSuccessJson('Login Succesfull', $getTokenByIdUser);
                    }
                } else { # Jika Token Belum Ada (Insert Token)
                    $id_user            = $user->id_user;
                    $token              = $this->CreateTokenLogin($user->password_user);
                    $expired            = Carbon::now()->addHours(2);
                    $insertTokenLogin   = $this->tokens->InsertTokenLogin($id_user, $token, $expired);
                    $response                = $this->response->ResponseSuccessJson('Login Succesfull', $insertTokenLogin);
                }
            } else {
                $response               = $this->response->ResponseEmptyJson('Password yang ada masukan tidak cocok');
            }
            return $response;
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }
}
