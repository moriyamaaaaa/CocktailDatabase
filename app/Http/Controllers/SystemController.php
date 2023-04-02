<?php

namespace App\Http\Controllers;

use App\Cocktail;
use App\Http\Controllers\Controller;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\CategoryFactory;
use App\Http\Resources\CocktailSearch\CategoryMiddleResource;
use App\Http\Resources\Detail\CocktailResourceForDetail;
use App\Kind;
use App\Method;
use App\Recipe;
use Reqest;
use App\Http\Resources\CocktailSearch\KindResource;
use App\Http\Resources\CocktailSearch\MethodResource;
use DB;

class SystemController extends Controller
{
    public function insertYoutubeDatetime(){
        //最新youtube動画のカクテルインスタンスを取得
        $cc=Cocktail::whereNotNull("youtube")->get();
        foreach($cc as $c){
            if($c->cc_youtube_created_at!=null){continue;}
            $c->cc_youtube_created_at=$c->updated_at;
            $c->save();
        }
        echo("正常に完了した");
    }

    public function insertRecipeCols(){
        $cc=Cocktail::get();
        foreach($cc as $c){
            //if($c->recipe_count!=null){continue;}
            $c->recipe_count=$this->calRecipeCount($c);
            $c->save();
        }
        echo("正常に完了した");
    }

    private function calRecipeCount(Cocktail $c):int{
        return Recipe::where("cocktail_id",$c->id)->where("is_optional",0)
            ->join('m_category','t_recipies.category','=','m_category.id')->where("m_category.kind","<>","5")->count();
    }

    public function test(){
        dd($this->calRecipeCount(Cocktail::find(1330)));
    }
}




