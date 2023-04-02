<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 06:04
 */
namespace App\Classes\Factory;

use App\Category;
use App\Brand;
use App\Classes\SearchCommon\Search;
use App\Http\Requests\Detail\Edit\EditCategoryValidate;
use App\Http\Requests\Detail\Edit\EditMiddleValidate;
use App\Middle;
use Illuminate\Support\Collection;

use App\Http\Requests\Detail\Edit\EditBrandValidate;
use Illuminate\Http\Request;

class BrandFactory
{
    use FactoryHelper;

    static function fromName(Array $strs,String $column):Collection{
        //与えられた文字列でLike検索をする
        $brand=Brand::with(['parent_r:id,name,name_eng', 'middle_r:id,name,name_eng']);//Eagerロード
        Search::find_Jap_or_Eng($brand,"m_brand",$strs,$column);
        return $brand->get();
    }

    static private function getFromIds(int $cid, ?int $mid, ?int $limit,?int $except_brand_id=null){
        $brands=Brand::where("category",$cid);
        if($mid!=null){
            //ミドルカテゴリが指定されていた場合は絞り込む
            $brands=$brands->where("middle_category",$mid);
        }
        if($limit!=null){
            $brands=$brands->limit(($limit));
        }
        if($except_brand_id!=null){
            $brands=$brands->where("id","<>",$except_brand_id);
        }
        return $brands->get();
    }
    static function getFromCategory(Category $c, ?int $limit,int $except_brand_id=null){
        return self::getFromIds($c->id,null, $limit, $except_brand_id);
    }
    static function getFromMiddle(Middle $m, ?int $limit,int $except_brand_id=null){
        return self::getFromIds($m->parent_r->id,$m->id, $limit, $except_brand_id);
    }
    static function getById(int $id):Brand{
        return Brand::find($id);
    }
    static function getFromCategoryExceptMiddle(Category $c,?Middle $except_m,Brand $except_b=null){
        $brands=Brand::where("category",$c->id);
        if(!empty($except_m)){
            $brands=$brands->where("middle_category","<>",$except_m->id);
        }
        $brands=$brands
                ->where("id","<>",$except_b->id)
                ->get();
        return $brands;
    }

    static function getByIdAndRelation(int $id):Brand{
        return Brand::with(["parent_r","middle_r"])->find($id);
    }

    public static function generateFromEditBrandValidate(EditBrandValidate $request):Brand{
        //EditBrandValidateクラスからインスタンスを生成する
        return self::generateFromRequest(BRAND,$request);
    }
    private static function generateFromEditValidate(Request $request,int $category_id,int $middle_id=null){
        $newRequest = new EditBrandValidate();
        $newRequest->merge([
            "category"=> $category_id,
            "middle"=> $middle_id,
            "name"=> $request->brand_name,
            "name_eng"=> $request->brand_name_eng,
            "strength"=> $request->brand_strength,
            "description"=> $request->brand_description,
            "youtube"=> $request->youtube,
            "youtube_time_hour"=> $request->brand_youtube_time_hour,
            "youtube_time_minute"=> $request->brand_youtube_time_minute,
            "youtube_time_second"=> $request->brand_youtube_time_second,
            "is_major"=> $request->brand_is_major,
            "is_like"=> $request->brand_is_like,
            "input_image"=> $request->brand_input_image,
        ]);

        return self::generateFromEditBrandValidate($newRequest);
    }
    public static function generateFromEditMiddleValidate(EditMiddleValidate $request,Middle $middle):Brand{
        //ミドルカテゴリ新規作成時、同時に作成された銘柄インスタンスを作成
        //むりやりリクエストを変換する。バリデーションはしてあるので漏れさえなければ大丈夫。
        return self::generateFromEditValidate($request,$middle->parent,$middle->id);
    }
    public static function generateFromEditCategoryValidate(EditCategoryValidate $request,Category $category):Brand{
        //メインカテゴリ新規作成時、同時に作成された銘柄インスタンスを作成
        //むりやりリクエストを変換する。バリデーションはしてあるので漏れさえなければ大丈夫。
        return self::generateFromEditValidate($request,$category->id);
    }
}
