<?php 
namespace App\Repositories\Auth;
use App\Http\Requests\RegisterRequest;
use App\Models\Response;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class AuthRepository implements AuthRepositoryInterface
{
    protected $response, $users;

    public function __construct()
    {
        $this->response     = new Response();
        $this->users        = new User();
    }
    public function Register(RegisterRequest $request) {
        try {
            $created_at = Carbon::now()->timezone('Asia/Jakarta');
            $nama_user      = $request->nama_user;
            $email_user     = $request->email_user;
            $password_user  = Hash::make($request->password_user);
            $created_at     = $created_at;
            $this->users->Register($nama_user, $email_user, $password_user, $created_at);
            $res            = $this->response->ResponseSuccessJson('Berhasil register', null);
            return $res;
        } catch (Exception $e) {
            return $this->response->ResponseInternalServerErrorJson($e->getMessage());
        }
    }
}
