<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Classes\Factory\DictionaryFactory;
use App\Classes\Markup;
use App\Dictionary;
use App\DictionaryCategory;
use App\Http\Resources\Admin\AutoInput\ParaPhraseResource;
use App\Http\Resources\Dictionary\DictionaryDetail;
use App\Http\Resources\Dictionary\DictionaryForIndex;
use App\Middle;
use App\Paraphrase;
use DB;
use App\Http\Requests\Detail\IdValidate;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function index(){
        return [
            "result"=>[
                "dictionary"=>DictionaryForIndex::collection(DictionaryFactory::getIndex())
            ]
        ];
    }
    public function paraphraseIndex(){
        return [
            "result"=>[
                "Paraphrases"=>ParaPhraseResource::collection(Paraphrase::all())
            ]
        ];
    }
    public function serachFromWords(Request $request){
        //converted,middleという文字列が渡ってくるので、それを元に返す。
        //dd($request->all());
        $brand=null;//未宣言だとなんかエラーが出る
        $category=Category::where("name_search",Markup::convert_to_name_search($request->input("converted")))->first();

        //クレーム・ド・カカオ/ホワイトorブラウンのようなパターンは、converted=クレームドカカオ、middle=ホワイト/ブラウンのようになっているので、middleから検索する。
        if(!empty($request->input("middle"))){
            //このようなパターンでは必ず$categoryがヒットしているはず
            $middle=Middle::where("name_search",Markup::convert_to_name_search($request->input("middle")))->where("parent",$category->id)->first();
        }else if(empty($category)){
            //Categoryにヒットしない→ブランド名だった
            $brand=Brand::where("name_search",Markup::convert_to_name_search($request->input("converted")))->first();
            if(empty($brand)){
                //Brandにもヒットしない→Middle名が直接指定されている
                $middle=Middle::where("name_search",Markup::convert_to_name_search($request->input("converted")))->first();
            }
        }
        //dd([$category]);
        //categoryかbrandどちらかには何かが入っているハズ。
        if(!empty($category)){
            $converted=$category->name;
        }else if(!empty($brand)){
            $converted=$brand->name;
        }else{
            $converted=$middle->name;
        }
        return [
            "result"=>[
                "converted"=>$converted,
                "middle"=>(!empty($middle))?$middle->name:null,
                "categoryId"=>(!empty($category))?$category->id:null,
                "middleId"=>(!empty($middle))?$middle->id:null,
                "brandId"=>(!empty($brand))?$brand->id:null,
            ]
        ];


    }
    public function detail(IdValidate $request){
        return [
            "result"=>[
                "dictionary"=>DictionaryDetail::make(Dictionary::with("dictionary_category_r")->find($request->input("id")))
            ]
        ];
    }

    public function test(){
        dd(DictionaryDetail::make(Dictionary::find(1)));
        dd(DictionaryFactory::getIndex());
        dd(DictionaryForIndex::collection(DictionaryFactory::getIndex()));
    }
}




