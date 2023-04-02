<?php

namespace App\Http\Controllers\Modules;

use App\Cocktail;
use App\Http\Controllers\Controller;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\CategoryFactory;
use App\Http\Resources\CocktailSearch\CategoryMiddleResource;
use App\Http\Resources\Detail\CocktailResourceForDetail;
use App\Kind;
use App\Method;
use Reqest;
use App\Http\Resources\CocktailSearch\KindResource;
use App\Http\Resources\CocktailSearch\MethodResource;
use DB;

class AmazonController extends Controller
{
    public function test(string $str){
        dd($this->getAmazonObj($str));
    }
    public function getAmazonObj(string $word){
        //検索したワードでAmazon画像を引っ張ってくる

    }

    public function getAmazonWidget(string $str){
        //ヴィジェット版(暫定　API使いたいですね)
    }
}




