<?php

namespace App\Classes\Factory;



use App\Brand;
use App\Category;
use App\Http\Requests\Detail\Edit\EditCocktailValidate;
use App\Middle;

trait RecipeCalc
{
    static private function calcStrength(EditCocktailValidate $request):float{
        //まずはレシピ配列を抜き出す
        $allVolume=0;$alcoholVolume=0;$tekiryou_array=[];//初期化
        foreach($request->input("recipes") as $recipe){
            if(!isset($recipe["category"])){continue;}
            //まずはアルコール度数を手に入れる
            $alc=0;unset($alc_brand);//ループ内変数の初期化
            if(isset($recipe["brand"])){
                $alc_brand=Brand::find($recipe["brand"]);
                $category=Category::find($alc_brand->category);
            }else{
                //ミドルカテゴリとメインカテゴリは処理を分ける
                if(isset($recipe["middle"])){
                    $model=Middle::find($recipe["middle"]);
                    $category=Category::find($model->parent);
                }else{
                    $model=Category::find($recipe["category"]);
                    $category=$model;
                }
                if($model->famous_brand_id){
                    $alc_brand=Brand::find($model->famous_brand_id);
                }//「有名な銘柄」がない＝ソフトドリンク等の、アルコール度数0%奴
            }
            $alc=(isset($alc_brand))?$alc_brand->volume:0;//ここでアルコール度数が求まる
            $convert_amount_int=self::convert_amount_int($category,$recipe["amount"]);
            if($convert_amount_int==999){
                //「適量」(もしくはそれに準ずる扱いを受けるもの)は別計算になるため一旦除外
                $tekiryou_array[]=$alc;
                continue;//とりあえずループを抜ける
            }
            $allVolume+=$convert_amount_int;//分母となる総容量を加算
            $alcoholVolume+=$convert_amount_int*$alc;//ml*%(つまり100倍の数値になっている)
        }
        //ここで$allVolume=「容量の合計」、$alcoholVolumeに「アルコール度数×容量」が入っている。

        //「適量」の解決
        if(!empty($tekiryou_array)){
            //「適量」自体は3倍希釈(つまりいま入っている量の2倍を加算する)
            $alcoholVolume+=array_sum($tekiryou_array)/count($tekiryou_array)*$allVolume*2;
            $allVolume+=$allVolume*2;
        }
        //dump($alcoholVolume);
        //dump($allVolume);
        //dump(round($alcoholVolume/$allVolume,1));
        if($allVolume==0){
            //基本となる分量が0と計算された場合(つまり「適量」しかない場合)、「適量」となるアルコール度数を代入することでお茶を濁すことにする。
            return array_sum($tekiryou_array)/count($tekiryou_array);
        }
        return round($alcoholVolume/$allVolume,1);
    }

    static public function format_amount(Category $category,String $amount=""):String{
        //もし「数字のみ」であれば、後ろにmlを付ける
        if(is_numeric($amount)){
            $amount.=($amount==1 && KindFactory::is_garnish($category))?"個":"ml";//「その他」と1の組み合わせのみ[1個]としたい
        }else if($amount==="nothing"){
            //自動入力用に「空欄」にしたい場合、ここで無理やり消去する
            $amount="";
        }else if($amount==="-"){
            //省略記法
            $amount="適量";
        }else if(strpos($amount,'t') !== false && strpos($amount,'tsp') === false){
            //省略記法
            $amount=$amount."sp";
        }else if(strpos($amount,'m') !== false && strpos($amount,'ml') === false){
            //省略記法
            $amount=$amount."l";
        }else if(strpos($amount,'da') !== false && strpos($amount,'dash') === false){
            //省略記法
            $amount=$amount."sh";
        }else if(strpos($amount,'dr') !== false && strpos($amount,'drop') === false){
            //省略記法
            $amount=$amount."op";
        }else if(strpos($amount,'c') !== false && strpos($amount,'cup') === false){
            //省略記法
            $amount=$amount."up";
        }
        //該当しなければそのまま
        return $amount;
    }

    static private function convert_amount_int(Category $category,String $amount=""):float{
        $amount=self::format_amount($category,$amount);

        /*amount語尾の成形はここまで。ここで規定の型になっている。*/
        
        //分量を、実際に計算に使う値に変換して返す。つまり、dash等は0として返す
        str_replace(["tsp","dash","個","片","枚"], "", $amount, $count);
        if($count>0){
            return 0;//誤差は最初に投げておく("/"が入ると途中で拾っちゃった)
        }

        //1/2cupなどは後ろで拾ってしまうので、先にここでreturnしておく。
        if(strpos($amount,"適量")!==false || strpos($amount,"cup")!==false){
            return 999;//適量の場合はわかりやすい値を投げる(cupの場合もmlや分数などと混同している場合思いっきり値がおかしくなるので、怖いから適量扱いにする)
        }

        if(strpos($amount,"ml")!==false || strpos($amount,"oz")!==false){
            //mlかozの場合は、それを抜いてやればよい。
            return (float)$amount;//これで"ml","oz"が抜けた数字が取れる。
        }
        if(strpos($amount,"/")!==false){
            list($fraction ,$denominator)=explode("/",$amount);
            return (float)$fraction*100/$denominator;
        }
        return 0;//それ以外は、誤差として計算する。
    }

    static private function recipe_count(EditCocktailValidate $request):int{
        //有効なrecipe_countを計算する
        return count(array_filter($request["recipes"], function($recipe) {
            //is_optional==falseと判定されるものの数を数えたい
            return (!isset($recipe["is_optional"])) || ($recipe["is_optional"]===false || $recipe["is_optional"]==="false");
        }));
    }
}
