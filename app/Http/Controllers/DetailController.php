<?php

namespace App\Http\Controllers;

use App\Classes\Factory\KindFactory;
use App\Classes\Factory\RecipeFactory;
use App\Classes\Markup;
use App\Cocktail;
use App\Http\Controllers\Auth\DetailEditController;
use App\Http\Controllers\Controller;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\CategoryFactory;
use App\Classes\Factory\MiddleFactory;
use App\Classes\Factory\BrandFactory;
use App\Http\Requests\Detail\Edit\EditCocktailValidate;
use App\Http\Requests\Detail\RegetCocktailValidate;
use App\Http\Resources\CocktailSearch\CocktailResource;
use App\Http\Resources\Detail\BrandResourceForDetail;
use App\Http\Resources\Detail\CategoryResourceForSub;
use App\Http\Resources\Detail\CocktailResourceForDetail;
use App\Http\Resources\Detail\KindResourceForCategoryDetail;
use App\Http\Resources\Detail\MiddleResourceForDetail;
use App\Http\Resources\Detail\RecipeResourceForCocktail;
use App\Kind;
use App\Paraphrase;
use App\Recipe;
use DB;
use App\Http\Requests\Detail\IdValidate;
use App\Http\Resources\Detail\CategoryResourceForDetail;
use App\Http\Resources\Detail\MiddleResourceForCategoryDetail;
use App\Http\Resources\FromNameSearch\BrandResource;
use App\Brand;
use App\Category;

class DetailController extends Controller
{
    public function category(IdValidate $request){
        $id=$request->input("id");
        $c=CategoryFactory::fromId($id);
        if(empty($c)){abort(500);}//もし見つからなければ500エラーを返して終了

        return[
            "result"=>[
                "category"=>CategoryResourceForDetail::make($c),
                "kind"=>KindResourceForCategoryDetail::make(Kind::find($c->kind)),
                "middles"=>MiddleResourceForCategoryDetail::collection(MiddleFactory::getFromCategory($c->id)),
                "famousBrand"=>BrandResource::make(Brand::find($c->famous_brand_id)),
                //"RandomCocktails"=>CocktailResource::collection(CocktailFactory::RandomByCategory($c,5)),
                "brands"=>BrandResource::collection(BrandFactory::getFromCategory($c,null))//コンポーネントが「名前から検索」と共通→リソースも共通
            ]
        ];
    }
    public function middle(IdValidate $request){
        $id=$request->input("id");
        $m=MiddleFactory::getByIdAndParent($id);
        if(empty($m)){abort(500);}//もし見つからなければ500エラーを返して終了
        //dd($m->parent_r->kind);
        return[
            "result"=>[
                "category"=>CategoryResourceForSub::make($m->parent_r),
                "kind"=>KindResourceForCategoryDetail::make(Kind::find($m->parent_r->kind)),
                "middle"=>MiddleResourceForDetail::make($m),
                "famousBrand"=>BrandResource::make(Brand::find($m->famous_brand_id)),
                //"RandomCocktails"=>CocktailResource::collection(CocktailFactory::RandomByMiddle($m,5)),
                "brands"=>BrandResource::collection(BrandFactory::getFromMiddle($m,null))//コンポーネントが「名前から検索」と共通→リソースも共通
            ]
        ];
    }
    public function brand(IdValidate $request){
        $id=$request->input("id");
        $b=BrandFactory::getByIdAndRelation($id);
        if(empty($b)){abort(500);}//もし見つからなければ500エラーを返して終了
        return[
            "result"=>[
                "category"=>CategoryResourceForSub::make($b->parent_r),
                "kind"=>KindResourceForCategoryDetail::make(Kind::find($b->parent_r->kind)),
                "middle"=>($b->middle_category)?MiddleResourceForCategoryDetail::make($b->middle_r):null,
                "brandDetail"=>BrandResourceForDetail::make($b),
                "brands_belong_category_except_middle"=>BrandResource::collection(BrandFactory::getFromCategoryExceptMiddle($b->parent_r,$b->middle_r,$b)),
                "brands_belong_middle"=>($b->middle_category)?BrandResource::collection(BrandFactory::getFromMiddle($b->middle_r,null,$b->id)):null,
            ]
        ];
    }
    public function cocktail(IdValidate $request){
        $id=$request->input("id");
        $c=CocktailFactory::getByIdAndRelation($id);
        if(empty($c)){abort(500);}//もし見つからなければ500エラーを返して終了
        //dd($c);
        return[
            "result"=>[
                "cocktailDetail"=>CocktailResourceForDetail::make($c),
                'recipe'=>RecipeResourceForCocktail::collection(RecipeFactory::getWithRelation($c))//リソース内で何故か取れなかったので妥協
            ]
        ];
    }

    public function regetCocktails(RegetCocktailValidate $request){
        //abort(500);
        $cs=CocktailFactory::RandomByGetRandom($request);
        if(empty($cs)){abort(500);}//もし見つからなければ500エラーを返して終了
        //dd($cs);
        return[
            "result"=>[
                "RandomCocktails"=>CocktailResource::collection($cs),
            ]
        ];
    }

    public function sameName(IdValidate $request){
        //IDと同じ名前のカクテルを検索
        return[
            "result"=>[
                "SameNameCocktails"=>CocktailResource::collection(CocktailFactory::sameName(Cocktail::find($request->input("id")))),
            ]
        ];
    }

    public function test(){
        $request=new IdValidate();
        $request->merge(["id"=>3]);
        $cont=new DetailController();
        $cont->brand($request);
        /*
        $request=new EditCocktailValidate();
        $request->merge([
            "name" => "ヌル",
            "name_search" => "ヌル",
            "name_eng" => "Null",
            "description" => "aaaaa",
            "is_major" => false,
            "base" => 2,
            "recipe_count" => 2,
            "sweet_degree" => null,
            "rate" => null,
            "note" => null,
            "method" => "4",
            "recipes"=>[
                "0"=>[
                    "category"=> "2",
                    "amount"=>"4/6",
                ],
                "1"=>[
                    "category"=>"94",
                    "middle"=>"59",
                    "amount"=>"2/6"
                ]
            ]
        ]);
        $cont=new DetailEditController();
        $cont->cocktail($request);
        //return $this->regetCocktails($request);
        */
    }
}




