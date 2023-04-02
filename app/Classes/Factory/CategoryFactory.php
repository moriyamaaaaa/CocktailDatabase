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
use App\Http\Requests\Detail\Edit\EditCategoryValidate;
use Illuminate\Support\Collection;
use App\Kind;
use DB;

class CategoryFactory
{
    use FactoryHelper;

    static function fromName(Array $strs,String $column):Collection{
        //与えられた文字列でLike検索をする
        $category=Category::with([]);//Eagerロード(こうしないとBuilderが生成してくれない...)
        Search::find_Jap_or_Eng($category,"m_category",$strs,$column);
        return $category->get();
    }

    static function get_kinds_for_form(): Collection{
        //フォーム用に、すべてのカテゴリ(およびミドルカテゴリ)を取ってくる
        return Category::with(["middle_r"/*,"kind"*/])->get();//ミドルカテゴリのリレーションも同時取得;
    }

    static function fromId(int $id):Category{
        //カテゴリIDから見つける
        return Category::find($id);
    }


    public static function generateFromEditCategoryValidate(EditCategoryValidate $request):Category{
        //EditValidateクラスからインスタンスを生成する
        return self::generateFromRequest(CATEGORY,$request);
    }
}
