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
use App\Http\Requests\Detail\Edit\EditCocktailValidate;
use App\Http\Requests\Detail\RegetCocktailValidate;
use App\Middle;
use Illuminate\Support\Collection;
use App\Classes\SearchCommon\Search;
use DB;
use App\Http\Requests\Search\SearchCocktail;
use App\Recipe;

class CocktailFactory
{
    use FactoryHelper;

    static function fromName(Array $strs,String $column):Collection{
        //与えられた文字列でLike検索をする
        //DB::enableQueryLog();
        //dd(DB::getQueryLog());
        $cocktail=Cocktail::with(['base_r','method_r']);

        Search::find_Jap_or_Eng($cocktail,"t_cocktails",$strs,$column);
        Search::isNotDraft($cocktail);//ドラフトのみを絞り込む

        //この時点で$cocktailには、非ドラフトを抽出するSQLが入っている
        return $cocktail->get();
    }

    static function intelligenceSearch(Array $strs,String $column):Collection{
        //DB::enableQueryLog();
        //インテリジェンスサーチ
        $cocktailIds=[];
        foreach ($strs as $str){
            if($str==""){continue;}
            //空白はAND条件として検索することにした
            //各配列に「リキュール」を付け足した配列を作成する(メロンと入力してもメロンリキュールが引っかかるようにしたい)
            $plus_liqueur_strs=[$str,($column==="name_search")?$str."リキュール":$str."liqueur"];

            //名前が一致するレコードを探す。スペースで区切って複数検索できるようにwhereInで検索。
            $category=Category::whereIn($column, $plus_liqueur_strs)->get();
            $middle=Middle::whereIn($column,$plus_liqueur_strs)->get();
            $brand=Brand::whereIn($column,$plus_liqueur_strs)->get();

            //特になにも見つからなかった(AND検索なので見つからない時点でreturnして良い)
            if($category->isEmpty() && $middle->isEmpty() && $brand->isEmpty()){return collect([]);}

            //何かしら見つかったので、検索する
            $recipes=DB::table('t_recipies');

            //含まれているレシピをそれぞれ検索し、それに紐付いているカクテルIDを取得したい
            foreach($category as $c){
                $recipes->orWhere("category",$c->id);
            }
            foreach($middle as $m){
                $recipes->orWhere("middle_category",$m->id);
            }
            foreach($brand as $b){
                $recipes->orWhere("brand",$b->id);
            }

            //カクテルIDからカクテルデータを抜き出す
            $cocktailIds[]=$recipes->pluck('cocktail_id');
        }

        $cocktail=Cocktail::with(['base_r','method_r']);
        foreach($cocktailIds as $ids){
            $cocktail->WhereIn("id",$ids);
        }
        //dd($cocktail->get());
        //dump(DB::getQueryLog());
        return $cocktail->where("is_draft",0)->get();

    }

    static function sameName(Cocktail $c):Collection{
        //与えられたカクテルと同じ名前のものを探す
        return Cocktail::where("name_eng",$c->name_eng)->where("id","<>",$c->id)->get();
    }

    static function cocktailSearch(SearchCocktail $request):Collection{
        //カクテル検索フォームからの検索

        DB::enableQueryLog();
        if($request->input("searchMethod")=="or"){
            //OR検索：チェックされているもののいずれかが入っていればいい
            //具体的には「親カテゴリが含まれ」かつ「ミドルカテゴリが含まれるか、nullである」カクテルIDを取得する。
            if(isset($request->input("Middle")[0]) && $request->input("Middle")[0]==999999){
                //フォームにミドルカテゴリを含んでいないが、全て含めたい場合の特殊コマンド
                $recipe=Recipe::whereIn('category', $request->input("Category"));
            }else{
                $recipe=Recipe::whereIn('category', $request->input("Category"))
                    ->where(function ($query) use ($request) {
                        $query->whereIn('middle_category',$request->input("Middle"))
                            ->orWhereNull('middle_category');
                    });
            }
            $ids=$recipe->pluck("cocktail_id");
        }

        if($request->input("searchMethod")=="and"){
            //AND検索
            //指定された材料でループを回す。「材料を含む」かつ「収集されたカクテルIDを含む」。
            //まず親カテゴリに関して回す
            foreach($request->input("Category") as $c){
                $recipe=Recipe::where('category', $c);
                if(!empty($ids)){
                    //2回目以降
                    $recipe=$recipe->whereIn("cocktail_id",$ids);//絞り込み
                }
                //つぎに、ミドルカテゴリに関して、nullか、middle配列に入っていればOK
                $recipe->where(function ($query) use ($request) {
                        $query->whereIn('middle_category',$request->input("Middle"))
                            ->orWhereNull('middle_category');
                    });

                //これで1ループ終了、カクテルIDだけ抽出する
                $ids=$recipe->pluck("cocktail_id");
                if(empty($ids)){break;}//この時点で残ってなければ走査する必要なし
            }
        }

        if($request->input("searchMethod")=="having"){
            //あるもの検索→持っていない、かつoptionalでないものが1つでも含まれるカクテルIDを除去
                $n_ids=Recipe::where(function ($query) use ($request) {
                    $query->whereNotIn("category",$request->input("Category"))
                        ->whereHas('base_r', function ($query) {
                            $query->where('kind', '<>', '5');
                        })//kind=5、つまり「その他」カテゴリは考慮する必要なし
                        ->orWhereNotIn("middle_category",$request->input("Middle")??null);//nullなら結果配列が空になるらしい　この場合OR句だし空でも問題ない
                })
                ->where("is_optional",0)
                    ->groupBy('cocktail_id')
                    ->pluck("cocktail_id")
                ->unique();

            //dd(DB::getQueryLog())
            //var_dump($n_ids);
            //dd(Cocktail::count());

            $ids=[];
            for($i=1;$i<=Cocktail::count();$i++){
                if(!$n_ids->contains($i)){$ids[]=$i;}//$n_idsに含まれていないものだけのID配列にする
            }
            $ids=collect($ids);//Collectionにする
        }

        //dd(DB::getQueryLog());
        //dd($ids);

        //まずは条件に合うカクテルIDを抽出した。
        $cocktail=Cocktail::whereIn("id",$ids)
            ->whereIn('method',$request->input("Method"))//メソッドで絞り込み
        ->where("is_draft",0);//当然ドラフトは除かなくてはいけない

        if($request->input("isEasily")){$cocktail=$cocktail->where("recipe_count","<=",3);}//簡単検索の場合

        //dd($cocktail->get());

        return $cocktail->get();//カクテルのデータを返す
    }
    static private function getCocktailIds(int $cid, ?int $mid, ?int $bid):Collection{
        //指定された数でランダム取得する。
        //カテゴリID等の条件から「それが含まれる」レシピを絞り込み
        $recipes=Recipe::where("category",$cid);

        if($mid != null){
            //ミドルカテゴリが指定されていたら、絞り込み検索する
            $recipes->where(function ($query) use ($mid) {
                $query->where('middle_category', '=', $mid)
                    ->orWhereNull('middle_category');
            });
        }else if($bid != null){
            //ミドルカテゴリが未指定でかつブランドIDが指定されていた場合「ミドルカテゴリがnullのものに限る」。
            //→ミドルが登録されている→なのに$midに値が入っていない→brandと関係ないミドルカテゴリ。カテゴリID指定だと混入してしまう。
            $recipes->whereNull('middle_category');
        }
        if($bid != null){
            $recipes->where(function ($query) use ($bid) {
                $query->where('brand', '=', $bid)
                    ->orWhereNull('brand');
            });
        }

        return $recipes->groupBy('cocktail_id')->pluck("cocktail_id");
    }

    static private function RandomByIDsCORE(int $cid, int $limit, ?int $mid, ?int $bid){
        //カクテルIDを取得
        $ids=self::getCocktailIds($cid, $mid, $bid);

        //順番にソートし、ドラフト回避して規定数取得する
        return Cocktail::whereIn("id",$ids)->where("is_draft",0)->inRandomOrder()->limit($limit);
    }
    static private function RandomByIDs(int $cid, int $limit, ?int $mid, ?int $bid):Collection{
        //カテゴリ、ミドルカテゴリ、銘柄IDなどで探す
        return self::RandomByIDsCORE($cid,$limit,$mid,$bid)->get();
    }

    static private function RandomByIDsonlyId(int $cid, int $limit, ?int $mid, ?int $bid):Collection{
        return self::RandomByIDsCORE($cid,$limit,$mid,$bid)->pluck("id");
    }

    static private function RandomByIDs2onlyId(int $limit, Recipe $r1, Recipe $r2):Collection{
        //レシピ2種が被っているカクテルを検索
        $cids1=self::getCocktailIds($r1->category,$r1->middle_category,$r1->brand);
        $cids2=self::getCocktailIds($r2->category,$r2->middle_category,$r2->brand);

        return Cocktail::whereIn("id", array_unique( array_merge($cids1->toArray(), $cids2->toArray()) ) )->where("is_draft",0)->inRandomOrder()->limit($limit)->pluck("id");
    }

    static private function RandomByBase(int $limit, int $baseId):Collection{
        return Cocktail::where("base",$baseId)->where("is_draft",0)->inRandomOrder()->limit($limit)->get();
    }

    static function RandomByGetRandom(RegetCocktailValidate $r):Collection{
        if( !empty($r->input("base")) ) {
            //「ベースでカクテルを探す」
            return self::RandomByBase($r->input("limit"),$r->input("base"));
        }elseif(!empty($r->input("category"))) {
            //カテゴリから探す
            return self::RandomByIDs($r->input("category"), $r->input("limit"), $r->input("middle"), $r->input("brand"));
        }elseif( !empty($r->input("cocktail")) ){
            //カクテルIDから探す
            return self::RandomByCocktail(Cocktail::find($r->input("cocktail")),$r->input("limit"));
        }elseif( !empty($r->input("method")) ){
            //製法IDから探す
            return Cocktail::where("method",$r->input("method"))->where("is_draft",0)->inRandomOrder()->limit($r->input("limit"))->get();
        }elseif( !empty($r->input("glass")) ){
            //グラスIDから探す
            return Cocktail::where("glass",$r->input("glass"))->where("is_draft",0)->inRandomOrder()->limit($r->input("limit"))->get();
        }
    }
    static function RandomByCategory(Category $c,int $limit):Collection{
        return self::RandomByIDs($c->id,$limit,null,null);
    }
    static function RandomByMiddle(Middle $m,int $limit):Collection{
        return self::RandomByIDs($m->parent_r->id,$limit,$m->id,null);
    }
    static function RandomByBrand(Brand $b,int $limit):Collection{
        return self::RandomByIDs($b->parent_r->id,$limit,$b->middle_r->id,$b->id);
    }
    static function RandomByCocktail(Cocktail $c,int $limit):Collection{
        //カクテルIDから探す
        $rr=RecipeFactory::getByCocktail($c);

        //レシピ二種が被るもの
        $resultIds=self::RandomByIDs2onlyId($limit,$rr[0],$rr[1]);//カクテルレシピは2種は確定であるので

        if(count($resultIds)<$limit){
            foreach($rr as $r){
                $resultIds2=self::RandomByIDsonlyId($r->category,$r->middle_category,$r->brand);//ランダムでIDを取得する
                $resultIds=array_unique( array_merge($resultIds->toArray(), $resultIds2->toArray()) );//マージする
                if(count($resultIds)>=$limit){break;}//$limit以上カクテルが取れたので終了
            }
        }
        return Cocktail::whereIn("id",$resultIds)->inRandomOrder()->limit($limit)->get();
    }

    static function getByName(string $name):Cocktail{
        return Cocktail::where("name",$name)->first();
    }

    static function getById(int $id):Cocktail{
        return Cocktail::find($id);
    }
    static function getByIdAndRelation(int $id):Cocktail{
        return Cocktail::with(["base_r","method_r","glass_r","ice_r"])->find($id);
    }


    public static function generateFromEditCocktailValidate(EditCocktailValidate $request):Cocktail{
        //EditBrandValidateクラスからインスタンスを生成する
        return self::generateFromRequest(COCKTAIL,$request);
    }
}
