<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 06:04
 */
namespace App\Classes\Factory;

use App\Category;
use App\Classes\SearchCommon\Search;
use App\Recipe;
use App\RecipeInstance;
use App\Rules\Amount;
use Illuminate\Support\Collection;
use App\Kind;
use DB;

class AutoInputInfo
{
    public $recipeInstances=[];
    public $rimmed_garnish="";
    public $garnish_txt;//退避用

    public $result;
    private $errors=array();//strClassは扱いづらかったので仕方なく

    private $floats=array();
    private $drops=array();
    private $sprinkles=array();
    public $is_push_coffee=false;

    public $amount_raw="";

    //絞りかける。
    private $peels=[
        "レモンピール",
        "ライムピール",
        "オレンジピール",
        "グレープフルーツピール"
    ];
    public $peelArray=[];
    //振りかける。
    private $dashes=[
        "ナツメグ","チョコレートチップ",
    ];
    public $dashArray=[];

    //飾って完成。
    private $cuts=[
        "カットレモン","スライスレモン","レモンスライス","スパイラルレモンピール","レモンツイスト",
        "カットライム","スライスライム","ライムスライス",
        "カットオレンジ","スライスオレンジ","オレンジスライス",
        "カットパイナップル","スライスパイナップル","パイナップルスライス",

        "マラスキーノ・チェリー","マラスキーノチェリー","ミント・チェリー","ミントチェリー","スタッフドオリーブ",

        "シナモンスティック","クローブ",

        "ミントリーフ",
        "パールオニオン"
    ];
    public $cutArray=[];
    public $others="";

    public function recipeInstance():RecipeInstance{
        if(!empty($this->recipeInstance)){return $this->recipeInstance;}
        return new RecipeInstance;
    }
    public function is_hot():bool{
        foreach($this->recipeInstances as $instance){
            if($instance->is_hot()){
                return true;
            }
        }
        return false;
    }
    public function pushError(string $msg){
        $this->errors[]=$msg;
    }
    public function setInstance(RecipeInstance $instance){
        $this->recipeInstances[]=$instance;
        return $this;
    }

    public function pushFroat(string $name){
        $this->floats[]=$name;
    }
    public function pushDrops(string $name){
        $this->drops[]=$name;
    }
    public function pushSprinkles(string $name){
        $this->sprinkles[]=$name;
    }

    public function strip_float_and_switchProp(string $name, string $amount):string{
        foreach([
                    " （フロート）","（フロート)","（フロート）"//空白を含んでいるところに注意
                ] as $froat_str){
            if(strpos($amount, $froat_str)){
                $amount=str_replace($froat_str, '', $amount);//文字列を消去し
                $this->pushFroat($name);//怖いから変更するのは後にしとこ...2
                break;
            }
        }
        return $amount;
    }
    public function strip_pushCoffee_and_switchProp(string $amount):string{
        foreach([
                    " （プースカフェスタイル）"," （プースカフェスタイル)",//空白を含んでいるところに注意
                ] as $push_str){
            if(strpos($amount, $push_str)){
                $amount=str_replace($push_str, '', $amount);//文字列を消去し
                $this->is_push_coffee=true;
                break;
            }
        }
        return $amount;
    }
    public function strip_drop_and_switchProp(string $name, string $amount):string{
        $drop_strs=[
            "（沈める）",//空白を含んでいるところに注意
            "（沈める)",
            "（ドロップ）",
        ];
        foreach($drop_strs as $drop_str){
            if(strpos($amount, $drop_str)){
                $amount=str_replace($drop_str, '', $amount);//文字列を消去し
                $this->pushDrops($name);
            }
        }
        return $amount;
    }
    public function strip_sprinkle_and_switchProp(string $name, string $amount):string{
        $drop_strs=[
            "（振りかける）"=>"",
            "（振りかける） "=>"",
            "を振りかける"=>"",
        ];
        foreach($drop_strs as $drop_str=>$after){
            if(strpos($amount, $drop_str)){
                $amount=str_replace($drop_str, $after, $amount);//文字列を消去し
                $this->pushSprinkles($name);
            }
        }
        return $amount;
    }

    public function set_garnishes(string $text){
        //副材料をパースしてレシピに入れる
        $garnishes=explode("、",$text);//パースする
        //dump($text);
        //dump($garnishes);
        foreach($garnishes as $key=>$g){
            //dump($g);
            if(in_array($g, $this->cuts)){
                $this->cutArray[]=$g;
            }else if(in_array($g, $this->peels)){
                $this->peelArray[]=$g;
                unset($garnishes[$key]);
            }else if(in_array($g, $this->dashes)){
                $this->dashArray[]=$g;
                unset($garnishes[$key]);
            }else if(in_array($g, ["ストロー"])){
                $straw=$g;
                unset($garnishes[$key]);
                continue;
            }else{
                //見つからない。特にする処理はない。
                continue;
            }
            $recipeinstance=RecipeInstance::set_garnish_profile($g);
            if($recipeinstance!=null){
                //パラフレーズで見つかった。レシピに格納する
                $this->setInstance($recipeinstance);
                unset($garnishes[$key]);
            }
        }
        if(isset($straw)){$this->others.=$straw."で飲む。".PHP_EOL;}
        //dump($garnishes);
        if(!empty($garnishes)){
            //dump($garnishes);
            $str="";
            foreach($garnishes as $g){
                $str=$g."、";
            }
            $this->others.="副材料：".mb_substr($str, 0,-1).PHP_EOL;//なんかややこしくなりそうだから見つからないやつは補足にぶっ込んでおく
        }

    }

    public function generateGarnishNote():String{
        $str="";
        if(!empty($this->peelArray)){
            $str.=implode("、", $this->peelArray)."を絞りかける。";
        }
        if(!empty($this->dashArray)){
            $str.=implode("、", $this->dashArray)."は振りかける。";
        }
        if(!empty($this->cutArray)){
            $str.=implode("、", $this->cutArray)."を飾って完成。";
        }
        $str.=$this->others;
        return $str;
    }

    public function errorArray():Array{
        $errors=$this->errors;
        foreach($this->recipeInstances as $instance){
            foreach($instance->error as $e){
                $errors[]=$e;
            }
        }
        return $errors;
    }
    public function recipeArray():Array{
        //レシピインスタンスを分かりやすい配列に置換する
        $result=[];
        foreach ($this->recipeInstances as $instance){
            $result[]=$instance->resourceArray();
        }
        return $result;
    }

    public function insertRecipes(Cocktail $c){
        //カクテルIDが確定したのでレシピインスタンスをRecipeとして代入する
        foreach($this->recipeInstances as $instance){
            if(!empty($instance->getCategory())){
                Recipe::insert([
                    "cocktail_id"=>$c->id,
                    "category"=>$instance->getCategory()->id,
                    "middle_category"=>$instance->getMiddle()->id?:null,
                    "brand"=>$instance->getBrand()->id?:null,
                    "amount"=>$instance->amount,
                    "is_optional"=>false,
                ]);
            }
        }
    }

    public function getBaseCategoryId():?int{
        //ベースとなるカテゴリIDを返却する
        /*
        foreach($this->recipeInstances as $instance){
            if(!empty($instance->getCategory())){
                return $instance->getCategory()->id;
            }
        }*/
        if($this->recipeInstances[0] && !empty($this->recipeInstances[0]->getCategory()) ){
            return $this->recipeInstances[0]->getCategory()->id;
        }
        return null;
    }

}
