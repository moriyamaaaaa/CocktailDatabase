<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Cocktail;
use App\Http\Controllers\Controller;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\CategoryFactory;
use App\Http\Resources\CocktailSearch\CategoryMiddleResource;
use App\Http\Resources\Detail\CocktailResourceForDetail;
use App\Kind;
use App\Method;
use App\Middle;
use Reqest;
use App\Http\Resources\CocktailSearch\KindResource;
use App\Http\Resources\CocktailSearch\Children\MethodResource;
use DB;

class CommonController extends Controller
{
    public function getNewMovie(){
        //最新youtube動画のカクテルインスタンスを取得
        $c=Cocktail::with(["base_r","method_r"])->where("is_draft",0)->orderBy('cc_youtube_created_at', 'desc')->first();
        return [
            "result"=>[
                "cocktail"=>CocktailResourceForDetail::make($c)
            ]
        ];
    }

    public function get_kinds_for_form(){
        //フォーム用に、カテゴリ、ミドルカテゴリ、酒類大ジャンルを取ってくる(整形はしない　フロントビューに任せる)
        //dd(CategoryFactory::get_kinds_for_form()->slice(0, 10));
        return [
            "result"=>[
                "Categories"=>CategoryMiddleResource::collection( CategoryFactory::get_kinds_for_form() ),//親カテゴリとミドルカテゴリすべてをリレーションで取る
                "methods"=>MethodResource::collection( Method::all() ),
                "kinds"=>KindResource::collection( Kind::all() )
            ]
        ];
    }

    public function countCocktail(){
        return [
            "result"=>[
                "count"=>Cocktail::where("is_draft",0)->count()
            ]
        ];
    }

    public function cocktailRecent(int $count){
        //最新のカクテルを$count個取ってくる
        $c=Cocktail::with(["base_r","method_r"])->where("is_draft",0)->orderBy('updated_at', 'desc')->take($count)->get();
        return [
            "result"=>[
                "cocktail"=>CocktailResourceForDetail::collection($c)
            ]
        ];
    }

    public function cocktailRecommend(int $count){
        //おすすめカクテル
        $c=Cocktail::with(["base_r","method_r"])->where("is_draft",0)->where("rate",">=","3")->inRandomOrder()->take($count)->get();
        return [
            "result"=>[
                "cocktail"=>CocktailResourceForDetail::collection($c)
            ]
        ];
    }

    public function cocktailRandom(int $count){
        $c=Cocktail::with(["base_r","method_r"])->where("is_draft",0)->inRandomOrder()->take($count)->get();
        return [
            "result"=>[
                "cocktail"=>CocktailResourceForDetail::collection($c)
            ]
        ];
    }

    public function cocktailByMethod(int $id,int $count){
        $c=Cocktail::with(["base_r","method_r"])->where("method",$id)->where("is_draft",0)->inRandomOrder()->take($count)->get();
        return [
            "result"=>[
                "cocktail"=>CocktailResourceForDetail::collection($c)
            ]
        ];
    }

    public function RandomWalk(){
        $rand=rand(1, 4);
        switch ($rand){
            case 1:
                $instance=Cocktail::where("is_draft",0)->inRandomOrder()->first();
                $command="CocktailDetail";
                break;
            case 2:
                $instance=Category::inRandomOrder()->first();
                $command="CategoryDetail";
                break;
            case 3:
                $instance=Middle::inRandomOrder()->first();
                $command="MiddleDetail";
                break;
            case 4:
                $instance=Brand::inRandomOrder()->first();
                $command="BrandDetail";
                break;
        }

        return [
            "result"=>[
                "command"=>$command,
                "id"=>$instance->id
            ]
        ];
    }

    public function test(){
        return $this->get_kinds_for_form();
    }
}




