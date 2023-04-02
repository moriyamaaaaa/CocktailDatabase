<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('test','AffiliateController@main');
Route::get('test','Auth\DetailEditController@test');
Route::get('card/{command}/{id}','SNSCardController@display');
//Route::get('test','Auth\AutoInputController@test');
//Route::get('test','DictionaryController@test');
Route::get('sys/gen','SystemController@insertYoutubeDatetime');
Route::get('sys/genrec','SystemController@insertRecipeCols');

/*
Route::get('amazon/{word}', function ($word) {
    return view('amazon',["option"=>[
        "amzn_assoc_default_search_key"=>$word
    ]]);
});*/

/*twitter用*/
// ログインURL
Route::get('auth/twitter', 'Auth\TwitterController@redirectToProvider');
// コールバックURL
Route::get('Cocktail/auth/twitter/callback', 'Auth\TwitterController@handleProviderCallback');
// ログアウトURL
Route::get('auth/logout', 'Auth\TwitterController@logout');



Route::middleware(['auth:web'])->group(function () {
    //データ取得
    Route::post('Cocktail/admin/get/category', 'Auth\DetailEditController@getCategory');
    Route::post('Cocktail/admin/get/middle', 'Auth\DetailEditController@getMiddle');
    Route::post('Cocktail/admin/get/brand', 'Auth\DetailEditController@getBrand');
    Route::post('Cocktail/admin/get/cocktail', 'Auth\DetailEditController@getCocktail');

    Route::post('admin/submit/category', 'Auth\DetailEditController@category');
    Route::post('admin/submit/middle', 'Auth\DetailEditController@middle');
    Route::post('admin/submit/brand', 'Auth\DetailEditController@brand');
    Route::post('admin/submit/cocktail', 'Auth\DetailEditController@cocktail');
    //Route::post('admin/submit/dictionary', 'Auth\DetailEditController@dictionary');//面倒なのでサポート切り　旧版から入力のこと

    //削除
    Route::post('Cocktail/delete/cocktail', 'Auth\DetailEditController@delete_cocktail');

    //ダブりチェック
    Route::post('Cocktail/duplicate/check', 'Auth\DetailEditController@duplicate_check');
    Route::post('Cocktail/duplicate/get', 'Auth\DetailEditController@duplicate_get');
    Route::post('Cocktail/iskind5/check', 'Auth\DetailEditController@is_kind5_check');
    Route::post('Cocktail/iskind5/kind/check', 'Auth\DetailEditController@is_kind5_check_kindver');

    //オートインプット
    Route::post('Cocktail/autoinput/exe', 'Auth\AutoInputController@exe');
    Route::post('Cocktail/autoinput/nextCall', 'Auth\AutoInputController@nextCall');
    Route::get('open', 'Auth\AutoInputController@open');
    Route::get('admin/open', 'Auth\AutoInputController@open');

    Route::get('addSkipDB/{name}', 'Auth\AutoInputController@addSkipDB')->name("insert_skip_db");

});
Route::get('admin/login', function () {
    //loginのみは例外的に未認証でも許可
    return view('welcome');
});
Route::get('Cocktail/admin/login', function () {
    //loginのみは例外的に未認証でも許可
    return view('welcome');
});
/*
Route::get('Cocktail/admin', function () {
    //認証状態でのみ許可
    return view('welcome');
})->middleware('auth:web')->name("admin");
*/
Route::get('admin', function () {
    //認証状態でのみ許可
    return view('welcome');
})->name("admin");
Route::post('Cocktail/getuser', 'Auth\AuthController@getuser');

Route::prefix('api')->group(function () {
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
    Route::post('getCocktailList','SearchController@getAllNotDrafts');
    Route::post('getCocktailDraftList','SearchController@getAllDrafts');
    Route::post('getListForRecipe','SearchController@getListForRecipe');

//アフィリエイト
    Route::post('getAffiliateData','AffiliateController@getAffiliateData');
//ランダムウォーク
    Route::post('RandomWalk','CommonController@RandomWalk');

//その他
    Route::get('getDictionaryIndex','DictionaryController@index');
    Route::get('getParaphrase','DictionaryController@paraphraseIndex');
    Route::post('Paraphrase/serachFromWords','DictionaryController@serachFromWords');
    Route::post('dictionaryDetail','DictionaryController@detail');
});


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');


//Route::get('test', 'CommonController@test');
//Route::get('test', 'SearchController@test');
//Route::get('test/{str}', 'AmazonController@test');


