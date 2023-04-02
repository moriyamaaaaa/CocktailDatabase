<?php
namespace App\Http\Controllers\Auth;
use App\Category;
use App\Classes\Factory\BrandFactory;
use App\Classes\Factory\CategoryFactory;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\KindFactory;
use App\Classes\Factory\MiddleFactory;
use App\Classes\Factory\RecipeFactory;
use App\Classes\Markup;
use App\Cocktail;
use App\Dictionary;
use App\Http\Controllers\Controller;
use App\Http\Requests\Detail\Edit\DuplicateGetValidate;
use App\Http\Requests\Detail\Edit\DuplicateValidate;
use App\Http\Requests\Detail\Edit\EditBrandValidate;
use App\Http\Requests\Detail\Edit\EditCategoryValidate;
use App\Http\Requests\Detail\Edit\EditCocktailValidate;
use App\Http\Requests\Detail\Edit\EditMiddleValidate;
use App\Http\Requests\Detail\IdValidate;
use App\Http\Resources\Admin\AutoInput\AutoInputDubs;
use App\Http\Resources\Admin\Detail\BrandResourceForEdit;
use App\Http\Resources\Admin\Detail\CategoryResourceForEdit;
use App\Http\Resources\Admin\Detail\CocktailResourceForEdit;
use App\Http\Resources\Admin\Detail\MiddleResourceForEdit;
use App\Http\Resources\Admin\Detail\RecipeResourceForEdit;
use App\Http\Resources\Admin\UserDataForVuex;
use App\Middle;
use App\Recipe;
use Auth;
use DB;
use App\Brand;
use Illuminate\Http\Request;

class DetailEditController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');//認証済でない限りこのコントローラーにアクセスさせない
    }

    function getCategory(IdValidate $request){
        //IDからブランド情報を取得する
        $c=Category::find($request->id);
        if(empty($c)){abort(500);}//もし見つからなければ500エラーを返して終了
        return[
            "result"=>[
                "category"=>CategoryResourceForEdit::make($c),
            ]
        ];
    }
    function getMiddle(IdValidate $request){
        //IDからブランド情報を取得する
        $m=Middle::find($request->id);
        if(empty($m)){abort(500);}//もし見つからなければ500エラーを返して終了
        return[
            "result"=>[
                "middle"=>MiddleResourceForEdit::make($m),
            ]
        ];
    }
    function getBrand(IdValidate $request){
        //IDからブランド情報を取得する
        $b=Brand::find($request->id);
        if(empty($b)){abort(500);}//もし見つからなければ500エラーを返して終了
        return[
            "result"=>[
                "brand"=>BrandResourceForEdit::make($b),
            ]
        ];
    }
    function getCocktail(IdValidate $request){
        //IDからブランド情報を取得する
        $c=Cocktail::find($request->id);
        if(empty($c)){abort(500,"no match id");}//もし見つからなければ500エラーを返して終了
        return[
            "result"=>[
                "cocktail"=>CocktailResourceForEdit::make($c),
                "recipes"=>RecipeResourceForEdit::collection(Recipe::where("cocktail_id",$c->id)->get())
            ]
        ];
    }

    private function insertFamousBrand(Request $request,$model):?Brand{
        //次に、もし銘柄指定でなければ、銘柄を挿入する
        if(!empty($request->brand_id)){
            return null;
        }
        //ただし、brand_*が存在していないパターン、例えば「その他」カテゴリの場合はスルー
        if(empty($request->brand_name)){
            return null;
        }
        if(get_class($model)=="App\Category"){
            $brand= BrandFactory::generateFromEditCategoryValidate($request,$model);
        }
        if(get_class($model)=="App\Middle"){
            $brand= BrandFactory::generateFromEditMiddleValidate($request,$model);
        }
        DB::transaction(function ()  use(&$model,&$brand){
            //生成された銘柄をDBに保存する
            $brand->save();
            //最後に、そのIDを有名な銘柄にぶち込んでおわり
            $model->famous_brand_id=$brand->id;
            $model->save();
        });

        return $brand;
    }

    function category(EditCategoryValidate $request){
        //カテゴリ詳細のupsert
        DB::transaction(function ()  use($request){
            //まずリクエストからインスタンスを生成する
            $category =CategoryFactory::generateFromEditCategoryValidate($request);
            $category->save();//そのまま保存しちゃえばOK
            $brand=$this->insertFamousBrand($request,$category);
        });
        return;
    }


    function middle(EditMiddleValidate $request){
        //ミドル詳細のupsert
        //「親カテゴリに変更有」かつ「その親カテゴリに属する有名な銘柄がある」場合のカテゴリ変更はリジェクト
        //↑インスタンス取得が二度手間になるので、データ挿入時にチェック

        DB::transaction(function ()  use($request){
            //まずリクエストからインスタンスを生成する
            $middle = MiddleFactory::generateFromEditMiddleValidate($request);
            $middle->save();//そのまま保存しちゃえばOK
            $brand=$this->insertFamousBrand($request,$middle);
        });
        return;
    }
    function brand(EditBrandValidate $request):Brand{
        //ブランド詳細のupsert
        $brand= new Brand();
        DB::transaction(function ()  use($request, &$brand){
            //まずリクエストからインスタンスを生成する
            $brand =BrandFactory::generateFromEditBrandValidate($request);
            $brand->save();//そのまま保存しちゃえばOK
        });
        return $brand;
    }

    function cocktail(EditCocktailValidate $request):Cocktail{
        $cocktail= new Cocktail();//cocktailインスタンスをDBスコープの外に出して、返り値として使えるようにするため
        DB::transaction(function ()  use($request, &$cocktail){
            //まずリクエストからインスタンスを生成する
            $cocktail =CocktailFactory::generateFromEditCocktailValidate($request);
            $cocktail->save();//そのまま保存しちゃえばOK

            //カクテルIDが確定したのでレシピも挿入する
            RecipeFactory::saveRecipe($cocktail,$request);
        });
        return $cocktail;
    }

    function delete_cocktail(IdValidate $request){
        Cocktail::find($request->input("id"))->delete();
    }


    function duplicate_check(DuplicateValidate $request){
        //与えられた名前がダブってるかどうかのチェック
        //該当するレコードが存在していれば、重複していることになる
        $column=($request->is_eng)?"name_eng":"name_search";
        $str=($request->is_eng)?$request->str:Markup::convert_to_name_search($request->str);
        if($request->command=="Brand"){
            $result=Brand::where($column,$str)->exists();
        }elseif($request->command=="Middle"){
            $result=Middle::where("parent",$request->parent)->where($column,$str)->exists();
        }elseif($request->command=="Category"){
            $result=Category::where($column,$str)->exists();
        }elseif($request->command=="Cocktail"){
            $result=Cocktail::where($column,$str)->exists();
        }elseif($request->command=="Dictionary"){
            $result=Dictionary::where($column,$str)->exists();
        }

        return[
            "result"=>[
                "is_duplicate"=>$result,
            ]
        ];
    }

    function duplicate_get(DuplicateGetValidate $request){
        $dub_cocktails=Cocktail::where("name_eng",$request->input("name_eng"))
            ->orWhere("name_search",Markup::convert_to_name_search($request->input("name")))->get()->except([$request->input("removeId")]);

        //$dub_cocktailsに名前がダブっているカクテルのコレクション、$request->input("removeId")に対象となるカクテルのIDが入っている。
        //これを用いて、材料が完全一致しているカクテルの順番に並び替える
        $cocktail_recipes=Recipe::where("cocktail_id",$request->input("removeId"))->get();
        $cocktail_recipes_categoryIds=Recipe::where("cocktail_id",$request->input("removeId"))->pluck("category");

        //dump($dub_cocktails);
        //dump($cocktail_recipes_categoryIds);

        //レシピが同一のカクテルIDを抽出
        $amount_match_cocktail_ids=[];
        $complete_match_cocktail_ids=[];
        $partial_match_cocktail_ids=[];
        $not_match_cocktail_ids=[];
        foreach ($dub_cocktails as $dub){
            $dub_recipes_query=Recipe::where("cocktail_id",$dub->id);
            $dub_recipes_categoryIds=$dub_recipes_query->pluck("category");
            if($cocktail_recipes_categoryIds->diff($dub_recipes_categoryIds)->isNotEmpty()){
                //元レシピから重複先レシピを減算、レシピが残っている＝足りないレシピがあるので終了
                $not_match_cocktail_ids[]=$dub->id;
                continue;
            }
            //とりあえずレシピ自体は足りているので詳細な比較
            if($cocktail_recipes_categoryIds->count()===$dub_recipes_categoryIds->count()){
                //レシピ(親カテゴリ)が完全一致
                //分量すら完全一致しているか
                $is_amount_check=true;
                foreach ($dub_recipes_query->get() as $dub_recipe_column){
                    $is_amount_check=$cocktail_recipes->search(function ($cocktail_recipe, $key) use ($dub_recipe_column){
                        if($cocktail_recipe->category==$dub_recipe_column->category){
                            if($cocktail_recipe->amount!=$dub_recipe_column->amount){
                                return false;
                            }
                            return true;
                        }
                    });
                    if($is_amount_check===false){
                        break;//一度でもチェックに引っかかればそれはもう別レシピ
                    }
                }
                if($is_amount_check){
                    $amount_match_cocktail_ids[]=$dub->id;//量まで同一
                }else{
                    $complete_match_cocktail_ids[]=$dub->id;
                }
                continue;
            }
            //レシピの数が違う＝部分一致
            $partial_match_cocktail_ids[]=$dub->id;
        }
        /*
      dump([
            $amount_match_cocktail_ids,
            $complete_match_cocktail_ids,
            $partial_match_cocktail_ids,
            $not_match_cocktail_ids
        ]);*/
        //ソートしていく
        $result=array_merge(
            Cocktail::whereIn("id",$amount_match_cocktail_ids)->get()->all(),
            Cocktail::whereIn("id",$complete_match_cocktail_ids)->get()->all(),
            Cocktail::whereIn("id",$partial_match_cocktail_ids)->get()->all(),
            Cocktail::whereIn("id",$not_match_cocktail_ids)->get()->all()
        );
        $result=collect($result);
        //dd($result);
        return [
            //"result"=>AutoInputDubs::collection($dub_cocktails)
            "result"=>AutoInputDubs::collection($result)
        ];
    }
    /*
    function duplicate_get(DuplicateGetValidate $request){
        $dub_cocktails=Cocktail::where("name_eng",$request->input("name_eng"))
            ->orWhere("name_search",Markup::convert_to_name_search($request->input("name")))->get()->except([$request->input("removeId")]);

        return [
            //"result"=>AutoInputDubs::collection($dub_cocktails)
            "result"=>AutoInputDubs::collection($dub_cocktails)
        ];
    }*/

    function is_kind5_check(IdValidate $request){
        //指定されたメインカテゴリが「その他」カテゴリかどうかをチェックする
        return[
            "result"=>[
                "is_kind5"=>KindFactory::is_kind5_fromCategory($request->id)
            ]
        ];
    }
    function is_kind5_check_kindver(IdValidate $request){
        //指定された大カテゴリが「その他」カテゴリかどうかをチェックする
        return[
            "result"=>[
                "is_kind5"=>KindFactory::is_kind5_fromKindId($request->id)
            ]
        ];
    }
}
