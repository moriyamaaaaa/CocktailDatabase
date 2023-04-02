<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Classes\Factory\DictionaryFactory;
use App\Cocktail;
use App\Http\Controllers\Controller;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\CategoryFactory;
use App\Classes\Factory\MiddleFactory;
use App\Classes\SearchCommon\Search;
use App\Http\Requests\Search\SearchFromWord;
use App\Classes\Factory\BrandFactory;
use App\Http\Resources\Admin\Detail\BrandResourceForList;
use App\Http\Resources\Admin\Detail\BrandResourceForRecipe;
use App\Http\Resources\Admin\Detail\CategoryResourceForRecipe;
use App\Http\Resources\Admin\Detail\MiddleResourceForRecipe;
use App\Http\Resources\CocktailSearch\CocktailResource;
use App\Http\Resources\CocktailSearch\MethodResource;
use App\Http\Resources\Detail\CategoryResourceForSub;
use App\Http\Resources\Detail\KindResourceForCategoryDetail;
use App\Http\Resources\Detail\MiddleResourceWithDisplayCategory;
use App\Http\Resources\Detail\sub\GlassResourceForSub;
use App\Http\Resources\Detail\sub\IceResourceForSub;
use App\Http\Resources\FromNameSearch\MiddleResource;
use App\Http\Resources\FromNameSearch\BrandResource;
use App\Http\Resources\FromNameSearch\CategoryResource;
use App\Http\Resources\Detail\BrandResourceForSub;
use App\Http\Resources\FromNameSearch\MiddleOnlyResource;
use App\Http\Resources\CocktailSearch\CocktailResourceMin;
use App\Ice;
use App\Kind;
use App\Method;
use App\Middle;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\Search\SearchCocktail;
use phpDocumentor\Reflection\Types\Self_;

class SearchController extends Controller
{
    public function fromName(SearchFromWord $request){
        //abort(500);//テスト用
        //名前から検索
        //名前を入れた際、DBから「カクテル」「カテゴリ」「ミドルカテゴリ」「銘柄」「製法」を検索
        $needle=$request->get("word");
        //$needle="カルーア　";

        $column=(ctype_alnum($needle))?"name_eng":"name_search";
        $strs=Search::generate_search_array($needle);//「・」を削除し詰める。空白があれば分割する。同時に配列にする。

        //インテリジェンスサーチ
        $intelCocktail=CocktailFactory::intelligenceSearch($strs,$column);//英数字のみだった場合、英名を検索

        //カクテル
        $foundCocktail=CocktailFactory::fromName($strs,$column);//英数字のみだった場合、英名を検索

        //カテゴリ
        $foundCategory=CategoryFactory::fromName($strs,$column);

        //ミドルカテゴリ
        $foundMiddle=MiddleFactory::fromName($strs,$column);

        //銘柄
        $foundBrand=BrandFactory::fromName($strs,$column);

        //シリアライズして格納
        return[
            "result"=>[
                "Intelligence"=>CocktailResource::collection($intelCocktail),
                "Cocktail"=>CocktailResource::collection($foundCocktail),
                "Category"=>CategoryResource::collection($foundCategory),
                "Middle"=>MiddleResource::collection($foundMiddle),
                "Brand"=>BrandResource::collection($foundBrand),
                "count"=>count($intelCocktail)+count($foundCocktail)+count($foundCategory)+count($foundMiddle)+count($foundBrand)
                ]
        ];
    }

    public function cocktailSearch(SearchCocktail $request){
        //カクテル検索
        $founds=CocktailFactory::cocktailSearch($request);

        //abort(500);//テスト用

        //シリアライズして格納
        return[
            "result"=>[
                "Cocktail"=>CocktailResource::collection($founds),
                "count"=>count($founds)
            ]
        ];
    }

    public function getAllKinds(){
        return[
            "result"=>[
                "Kinds"=>KindResourceForCategoryDetail::collection(Kind::all()),
            ]
        ];
    }

    public function getAllMiddles(){
        return[
            "result"=>[
                "Middles"=>MiddleOnlyResource::collection(Middle::all()),
            ]
        ];
    }


    public function getAllMiddlesWithCategory(Request $request)
    {

        $midle=Middle::with(["parent_r"]);
        if(!empty($request->category_id)){
            $midle->where("parent",$request->category_id);
        }
        return[
            "result"=>[
                "Middles"=>MiddleResourceWithDisplayCategory::collection($midle->get()),
            ]
        ];
    }

    public function getAllBrands(){
        return[
            "result"=>[
                "Brands"=>BrandResourceForSub::collection(Brand::all()),
            ]
        ];
    }
    public function getAllBrandsWithCategory(Request $request){
        //dump($request->middle_id);
        $brand=Brand::with(["parent_r","middle_r"]);
        if(!empty($request->middle_id)){
            $brand->where("middle_category",$request->middle_id);
        }elseif(!empty($request->category_id)){
            $brand->where("category",$request->category_id);
        }
        return[
            "result"=>[
                "Brands"=>BrandResourceForList::collection($brand->get()),
            ]
        ];
    }

    public function getAllCocktails(){
        //ドラフトも含めた、全カクテル取得(管理画面用)
        return[
            "result"=>[
                "Cocktails"=>CocktailResourceMin::collection(Cocktail::all()),
            ]
        ];
    }

    public function getAllDrafts(){
        //ドラフトのみ
        return[
            "result"=>[
                "Cocktails"=>CocktailResourceMin::collection(Cocktail::where("is_draft",1)->get()),
            ]
        ];
    }
    public function getAllNotDrafts(){
        //ドラフト以外
        return[
            "result"=>[
                "Cocktails"=>CocktailResourceMin::collection(Cocktail::where("is_draft",0)->get()),
            ]
        ];
    }


    public function getListForRecipe(){
        return[
            "result"=>[
                "Categoryies"=>CategoryResourceForRecipe::collection(Category::all()),
                "Middles"=>MiddleResourceForRecipe::collection(Middle::all()),
                "Brands"=>BrandResourceForRecipe::collection(Brand::all()),
                "Glass"=>GlassResourceForSub::collection(DictionaryFactory::getGlasses()),
                "Ice"=>IceResourceForSub::collection(Ice::all()),
                "Methods"=>MethodResource::collection(Method::all()),
            ]
        ];
    }


    public function test(){
        $request=new SearchCocktail();
        $request->merge([
            "Category"=>[3,69,19,35],
            "Middle"=>[25],
            "Method"=>[1,2,3,5],
            "searchMethod"=>"having",
            //"isEasily"=>false
        ]);
        //$a=$this->fromName($request);
        //dd($a);
        return $this->cocktailSearch($request);
    }
}




