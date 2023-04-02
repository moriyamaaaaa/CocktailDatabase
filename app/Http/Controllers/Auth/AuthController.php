<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserDataForVuex;
use Illuminate\Http\Request;
use Socialite;
use Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');//認証済でない限りこのコントローラーにアクセスさせない
    }

    function getuser(Request $request){
        $user=Auth::User();

        return[
            "user"=>[
                "data"=>UserDataForVuex::make($user),
            ]
        ];
    }
}
