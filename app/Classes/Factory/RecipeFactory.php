<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 06:04
 */
namespace App\Classes\Factory;


use App\Brand;
use App\Category;
use App\Cocktail;
use App\Http\Requests\Detail\Edit\EditBrandValidate;
use App\Http\Requests\Detail\Edit\EditCocktailValidate;
use App\Http\Requests\Detail\Edit\EditMiddleValidate;
use App\Middle;
use App\Recipe;
use Illuminate\Support\Collection;

class RecipeFactory
{
    use RecipeCalc;

    static function getWithRelation(Cocktail $c):Collection{
        return Recipe::with(["base_r","middle_r","brand_r"])->where("cocktail_id",$c->id)->get();
    }

    static function getByCocktail(Cocktail $c):Collection{
        return Recipe::where("cocktail_id",$c->id)->get();
    }

    static function changeMiddlesParentIds(Middle $oldMiddle,EditMiddleValidate $request){
        //ミドルカテゴリの親カテゴリ変更時
        //カクテルのレシピで該当するものがあれば、数値を書き換えなくてはならない
        if(empty($oldMiddle->id) || $request->category==$oldMiddle->parent){return;}
        Recipe::where('category', $oldMiddle->parent)
            ->update(["category"=>$request->category]);

        //関連する銘柄の親カテゴリも変更になる
        Brand::where("category",$oldMiddle->parent)->update(["category"=>$request->category]);
        return;
    }
    static function changeBrandsParentAndMiddleIds(Brand $oldBrand, EditBrandValidate $request){
        //銘柄が属するカテゴリが変更になった時
        if($oldBrand->id==null || ($request->category==$oldBrand->category && $request->middle==$oldBrand->middle_category) ){return;}
        //この銘柄は親カテゴリとミドルカテゴリに何らかの変更が生じている
        Recipe::where('brand', $oldBrand->id)
            ->update(["category"=>$request->category,
                "middle_category"=>$request->middle]);
        return;
    }

    static function saveRecipe(Cocktail $cocktail,EditCocktailValidate $request):array{
        //レシピを保存する
        Recipe::where("cocktail_id",$cocktail->id)->delete();//まず紐付いているレシピを全部削除する
        $inserts=[];
        foreach($request["recipes"] as $recipe){
            if(!isset($recipe["category"])){continue;}
            $inserts[]=[
                "cocktail_id"=>$cocktail->id,
                "category"=>$recipe["category"],
                "middle_category"=>$recipe["middle"]??null,
                "brand"=>$recipe["brand"]??null,
                "amount"=>self::format_amount(Category::find($recipe["category"]),$recipe["amount"]),
                "is_optional"=>  isset($recipe["is_optional"]) && ($recipe["is_optional"]===true || $recipe["is_optional"]==="true") ,
            ];
        }
        Recipe::insert($inserts);
        return $inserts;
    }

    static function generateFromAutoInputInfo(AutoInputInfo $info, bool $allowError=false):array{
        //オートインプット用。「不完全かもしれない」レシピ用配列を生成する
        $result=[];
        foreach ($info->recipeInstances as $instance){
            try{
                $r=[];
                if($allowError){
                    $r["category"]=($instance->getCategory())?$instance->getCategory()->id:null;
                }else{
                    $r["category"]=$instance->getCategory()->id;
                }
                $r["middle"]=($instance->getMiddle())?$instance->getMiddle()->id:null;
                $r["brand"]=($instance->getBrand())?$instance->getBrand()->id:null;
                $r["amount"]=$instance->amount;
                $result[]=$r;
            }catch (\Exception $e){
                dd($instance);
            }

        }
        return $result;
    }
}
