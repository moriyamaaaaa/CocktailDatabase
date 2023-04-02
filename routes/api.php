<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//トップページデータ用
/*
Route::get('getNewMovie','CommonController@getNewMovie');
Route::get('CocktailCount','CommonController@countCocktail');
Route::get('CocktailRecent/{count}','CommonController@cocktailRecent');
Route::get('CocktailRecommend/{count}','CommonController@cocktailRecommend');
Route::get('CocktailRandom/{count}','CommonController@cocktailRandom');

//サーチ用
Route::post('fromName','SearchController@fromName');
Route::post('cocktailSearch','SearchController@cocktailSearch');
Route::post('getKindsForForm','CommonController@get_kinds_for_form');


//各論用
Route::post('categoryDetail','DetailController@category');
Route::post('middleDetail','DetailController@middle');
Route::post('brandDetail','DetailController@brand');
Route::post('cocktailDetail','DetailController@cocktail');
Route::post('getSameNameCocktail','DetailController@sameName');
Route::post('getRandomCocktail','DetailController@regetCocktails');

//一括取得(現状は管理画面用)
Route::post('getMiddleList','SearchController@getAllMiddles');
Route::post('getMiddleListWithCategory','SearchController@getAllMiddlesWithCategory');
Route::post('getBrandList','SearchController@getAllBrands');
Route::post('getKindList','SearchController@getAllKinds');
Route::post('getBrandListWithCategory','SearchController@getAllBrandsWithCategory');
Route::post('getCocktailList','SearchController@getAllCocktails');
Route::post('getListForRecipe','SearchController@getListForRecipe');

//その他
Route::get('getDictionaryIndex','DictionaryController@index');
Route::post('dictionaryDetail','DictionaryController@detail');
//Route::get('getAmazonObj/{word}','AmazonController@getAmazonObj');
/*
Route::group(['middleware' => 'auth:api'], function () {
    //ログイン状態でのみ閲覧可能
    Route::post('logout', 'Auth\LoginController@logout');
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::patch('settings/profile', 'Settings\ProfileController@update');
    Route::patch('settings/password', 'Settings\PasswordController@update');
});
Route::group(['middleware' => 'guest:api'], function () {
    //未ログイン状態でのみ許可
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');
    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});*/

