<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use App\Classes\Markup;
use App\Rules\Amount;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Classes\Exceptions\SkipAutoInputByRecipe;

class RecipeInstance
{
    public $amount="";
    public $raw_amount="";
    //private $is_optional;//オートインプットで任意、とされることはなくない？？？？
    private $paraphrase=false;
    private $category;
    private $middle=null;
    private $brand=null;
    private $raw_name;
    private $is_hot=false;
    public $error=[];

    public function is_hot():bool{
        return $this->is_hot;
    }
    private function generate_final_amount(string $amount):void{
        $this->amount_raw=$amount;//amonutはエラーが出ると空にしちゃうので表示用にコピーしておく
        if (!preg_match(Amount::$regex, $amount)) {
            $this->error[]="Amount「${amount}」の書式が正しくありません。";
        }else{
            $this->amount=$amount;
        }
        return;
    }
    public function getCategory():?Category{
        return $this->category;
    }
    public function getMiddle():?Middle{
        return $this->middle;
    }
    public function getBrand():?Brand{
        return $this->brand;
    }
    public function setParaphrase(string $name):?Paraphrase{
        return $this->paraphrase=Paraphrase::where("name",$name)->first();
    }
    private function convertParaphraseName():String{
        if(empty($this->paraphrase)){
            return $this->raw_name;
        }else{
            return $this->paraphrase->converted;
        }
    }

    public function resourceArray():Array{
        return[
           "category"=>$this->category->id?:null,
           "middle"=>$this->middle->id?:null,
           "brand"=>$this->brand->id?:null,
           "amount"=>$this->amount->id?:null,
           "is_optional"=>false,
        ];
    }
    private function getMiddleFromParaphrase():?Middle{
        if(!empty($this->paraphrase) && !empty($this->paraphrase->middle)){
            //特殊な処理
            $this->category=Category::where("name",$this->paraphrase->converted)->first();
            $this->middle=Middle::where("name",$this->paraphrase->middle)->where("parent",$this->category->id)->first();
            return $this->middle;
        }
        //名前からmiddleを検索
        return $this->middle=Middle::where("name",$this->convertParaphraseName())->first()?:null;
    }
    private function is_find():bool{
        return !empty($this->category);
    }

    static public function generateRecipeInstance(string $name, string $amount):RecipeInstance{
        $instance=new RecipeInstance();
        $instance->generate_final_amount($amount);
        $instance->raw_name=$name;
        return $instance->set_material_profile();
    }

    private function set_material_profile():RecipeInstance{
        //名前を渡せば、レシピに必要なデータが格納される
        $is_looped=false;

        $this->setParaphrase($this->raw_name);
        $search=$this->convertParaphraseName();
        get_material_loop:
        $search=Markup::convert_to_name_search($search);
        if($this->brand=Brand::where("name_search",$search)->first()){
            $this->category=Category::find($this->brand->category);
            $this->middle=Middle::find($this->brand->middle_category);
            //もしブランドの名前とカテゴリ(もしくはミドルカテゴリ)の名前が一致していた場合、そちらを優先する(ドランブイ問題)
            if($this->brand->name == $this->category->name || !empty($this->middle) && $this->middle->name == $this->brand->name){
                $this->brand=null;
            }

        }elseif($this->middle=Middle::where("name_search",$search)->first()){
            $this->category=Category::find($this->middle->parent);
        }else{
            $this->category=Category::where("name_search",$search)->first();
        }

        if(!$this->is_find()){
            //「◯◯リキュール」「◯◯ウォッカ」など、ケツに余計なものがくっついていたら除去してもう一度検索したい
            if (!$is_looped && preg_match("/(リキュール|ブランデー|ウオッカ|ウイスキー|ウォッカ|ラム|テキーラ|ベルモット|シェリー)$/",$search,$matches)) {
                $search=str_replace($matches[1] ,'', $search);
                $is_looped=true;
                $this->setParaphrase($search);
                if(!empty($this->paraphrase)){
                    $search=$this->paraphrase->converted;
                }
                goto get_material_loop;
            }else{
                //スキップDBに登録されていた場合、完全にスキップ
                if(DB::table('skip_db')->where('name', $search)->exists()){
                    throw new SkipAutoInputByRecipe();
                }

                //見つからない。エラー。
                    $str="材料<a href=\"https://www.google.co.jp/search?q={$search}+酒\" target=\"_blank\">{$search}</a>";
                if($search!=$this->raw_name) {
                    $str.= "(元：<a href=\"https://www.google.co.jp/search?q={$this->raw_name}+酒\" target=\"_blank\">{$this->raw_name}</a>)";
                }
                $str.="が見つかりません。";
                $str.="<a href=\"".route("insert_skip_db",['name' => $search])."\">スキップ</a>";
                $this->error[]=$str;
            }
        }
        return $this;
        //return ["error"=>"材料「<a href=\"https://www.google.co.jp/search?q={$name_after}+酒\" target=\"_blank\">{$name_after}</a>(元：<a href=\"https://www.google.co.jp/search?q={$name}+酒\" target=\"_blank\">{$name}</a>)」が見つかりません。"];
    }

    static public function set_garnish_profile(string $name,string $amount="1"):?RecipeInstance{
        //「副材料」用。BrandやMiddleに問い合わせるのが無駄かなって思って。
        $instance=new RecipeInstance();
        $instance->amount=$amount;//副材料はamountがないので初期値。
        $instance->raw_amount=$instance->amount;
        $instance->raw_name=$name;
        $instance->setParaphrase($instance->raw_name);
        $instance->category=Category::where("name_search",Markup::convert_to_name_search($instance->convertParaphraseName()))->first();
        if( $instance->category=Category::where("name_search",Markup::convert_to_name_search($instance->convertParaphraseName()))->first() ){
            //特にすることはないけど
        }elseif($instance->middle=$instance->getMiddleFromParaphrase()){
            $instance->category=Category::find($instance->middle->parent);
        }else{
           //見つからない。スルー。
            return null;
        }
        return $instance;
    }

}
