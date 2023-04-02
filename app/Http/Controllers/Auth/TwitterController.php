<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use mysql_xdevapi\Exception;
use Socialite;
use Auth;
use App\User;

class TwitterController extends Controller
{

    // ログイン
    public function redirectToProvider(){
        return Socialite::driver('twitter')->redirect();
    }

    // コールバック
    public function handleProviderCallback(){
        try {
            $twitterUser = Socialite::driver('twitter')->user();
            $user = User::where('twitter_id', $twitterUser->id)->first();
            if(empty($user)){
                //メインアカウントでも僕のアカウントとして許可
                if($twitterUser->id==156581751){
                    $user = User::where('id', 1)->first();//僕なので強制ログイン
                }else {
                    abort(403, 'twitter ID がfetchしません');
                }
            }
            Auth::login($user, true);
        } catch (Exception $e) {
            return redirect('auth/twitter');
        }

        //dd(Auth::user());

        //ログインに成功した...
        return redirect()->route("admin");
    }

    // ログアウト
    public function logout()
    {
        // 各自ログアウト処理
        // 例
        Auth::logout();
        return redirect("/");
    }
}
