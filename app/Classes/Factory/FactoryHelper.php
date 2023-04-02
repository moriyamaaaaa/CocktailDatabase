<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-11-23
 * Time: 08:32
 */

namespace App\Classes\Factory;

use App\Classes\StorageCommon;
use App\Cocktail;
use App\Category;
use App\Middle;
use App\Brand;
use App\Dictionary;
use App\Classes\Markup;
use Carbon\Carbon;

define("COCKTAIL","Cocktail");
define("CATEGORY","Category");
define("MIDDLE","Middle");
define("BRAND","Brand");
define("DICTIONARY","Dictionary");

trait FactoryHelper
{
     use RecipeCalc;

    //共通で使う機構のメソッド群
    private static function generateFromRequest(String $mode, $request)
    {
        switch ($mode){
            case COCKTAIL:
            case CATEGORY:
            case MIDDLE:
            case BRAND:
            case DICTIONARY:
                $modelClassPath="App\\".$mode;
                break;
            default:
                abort(500);
        }
        //EditBrandValidateクラスからインスタンスを生成する
        if(!empty($request->id)){
            //すでにある場合
            $model = $modelClassPath::find($request->input("id"));
        }else{
            //新規作成の場合
            $model = new $modelClassPath;
        }
//あとは原則上書き
        //ただし......
        //ミドルカテゴリの親カテゴリが変更になった場合、それに紐付いた銘柄やレシピのカテゴリを変更する
        if($mode==MIDDLE){
            //「親カテゴリに変更有」かつ「その親カテゴリに属する有名な銘柄がある」場合のカテゴリ変更はリジェクト
            if($model->id!=0 && $model->parent!=$request->category){
                //まず、もともと属していた親カテゴリの「有名な銘柄」を見る
                $categoryInstance=Category::find($model->parent);
                $brandInstance=Brand::find($categoryInstance->famous_brand_id);
                //その有名な銘柄が「これから移動する予定のミドルカテゴリ」に属していたらアウト
                if($brandInstance->middle_category==$model->id){
                    abort(500,"このミドルカテゴリ内の「".$brandInstance->name."」が「".$categoryInstance->name."」の有名な銘柄として含まれてしまっています。");
                }
            }

            RecipeFactory::changeMiddlesParentIds($model,$request);
        }

        if($mode==BRAND && $request->id!=null  &&
            ($model->category!=$request->category || $model->middle_category!=$request->middle)
        ) {
            //「有名な銘柄」に含まれているもののカテゴリ変更はリジェクト
            if ($model->category != $request->category &&
                Category::where("famous_brand_id", $request->input("id"))->exists()) {
                abort(500, 'メインカテゴリの「有名な銘柄」に属しているのでリジェクトされました');
            }
            if ($model->middle_category != $request->middle &&
                Middle::where("famous_brand_id", $request->input("id"))->exists()) {
                abort(500, 'ミドルカテゴリの「有名な銘柄」に属しているのでリジェクトされました');
            }

            //ブランドの親カテゴリorミドルカテゴリが変更/追加された場合、レシピのカテゴリを変更する
            RecipeFactory::changeBrandsParentAndMiddleIds($model, $request);
        }

        //共通のもの

        //dump($request->all());
        $model->name=$request->input("name");
        $model->name_search=Markup::convert_to_name_search($request->input("name"));
        $model->name_eng=$request->input("name_eng");
        $model->description=Markup::mark_up($request->input("description"));
        $model->is_major=$request->is_major?:false;

        switch ($mode){
            case COCKTAIL:
                $model->base=$request->base;
                $model->volume=self::calcStrength($request);
                $model->recipe_count=self::recipe_count($request);
                $model->sweet_degree=$request->input("sweet_degree");
                $model->rate=$request->input("rate");
                $model->note=Markup::mark_up($request->input("note"));
                $model->method=$request->input("method");
                $model->glass=$request->input("glass");
                $model->ice=$request->input("ice");
                $model->is_draft=empty($request->input("description"));
                break;
            case CATEGORY:
                $model->kind=$request->kind;
                break;
            case MIDDLE:
                $model->parent=$request->category;
                break;
            case BRAND:
                $model->category=$request->category;
                $model->middle_category=$request->middle;
                $model->volume=$request->input("strength");
                break;
            case DICTIONARY:
                $model->category=$request->category;
                break;
        }

        switch($mode){
            case CATEGORY:
            case MIDDLE:
            $model->famous_brand_id=$request->brand_id??$model->famous_brand_id;
            $model->is_powder=$request->is_powder;
            case BRAND:
                $model->is_like=$request->is_like;
        }

        //画像関係
        //dump($request->input_image);//こういうの残しとくとカクテルをinsertした際にオートインプット等、js側で影響が出てしまう
        if(!empty($request->input_image)){
            $model->image=StorageCommon::saveFromDetailAdmin($request->input_image,$model->image??null);
        }
        $model->image_txt=$request->link_txt;
        $model->image_url=$request->link_url;

        $model->youtube=Markup::youtube($request->youtube);
        if(!empty($model->youtube)){
            $model->y_hour=$request->youtube_time_hour;
            $model->y_minute=$request->youtube_time_minute;
            $model->y_second=$request->youtube_time_second;
        }
        //歴史的背景により、カラム名が変わってしまっている不具合があるのでここで帳尻合わせをする
        switch($mode){
            case COCKTAIL:
                $youtube_column_name="cc_youtube_created_at";
                break;
            default:
                $youtube_column_name="youtube_created_at";
        }
        if( !empty($request->youtube) && ( empty($model->$youtube_column_name) || $request->youtube!=$model->youtube) ){
            //もしyoutubeが空でなく、作成時が空か、もしくはアドレスが更新されていれば現在時刻で塗り替える
            $model->$youtube_column_name=Carbon::now();
        }elseif(empty($request->input("youtube")) ){
            //youtubeが空＝消去された時はnullを入れる
            $model->$youtube_column_name=null;
        }

        return $model;
    }

}
