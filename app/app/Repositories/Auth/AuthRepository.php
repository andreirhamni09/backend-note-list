<?php 
namespace App\Repositories\Auth;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Helpers\ResponseHelper;
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
        $this->response     = new ResponseHelper();
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
            return $this->response->success('Register Berhasil', $user);
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
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
                        $updateToken        = $this->tokens->UpdateToken($id_user, $token, $expired);
                        $response                       = $this->response->success('Login Succesfull', $updateToken);
                    } else {
                        $response                = $this->response->success('Login Succesfull', $getTokenByIdUser);
                    }
                } else { # Jika Token Belum Ada (Insert Token)
                    $id_user            = $user->id_user;
                    $token              = $this->CreateTokenLogin($user->password_user);
                    $expired            = Carbon::now()->addHours(2);
                    $insertTokenLogin   = $this->tokens->InsertTokenLogin($id_user, $token, $expired);
                    $response                = $this->response->success('Login Succesfull', $insertTokenLogin);
                }
            } else {
                $data                   = [
                    'email_user'        => $request->email_user,
                    'password'          => $request->password_user
                ];
                $response               = $this->response->empty('Password yang ada masukan tidak cocok', $data);
            }
            return $response;
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }
    public function Logout($id_user) {
        try {
            $logout  = $this->tokens->DeleteTokens($id_user);
            return $this->response->success('Berhasil Logout', null);
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }
    public function tokenExpired($token) {
        try {
            $token = $this->tokens->GetTokenByToken($token);
            return $this->response->success('Data Token', $token);
        } catch (Exception $e) {
            return $this->response->internalError($e->getMessage());
        }
    }
}
