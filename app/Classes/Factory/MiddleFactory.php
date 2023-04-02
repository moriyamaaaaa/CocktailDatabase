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
use App\Http\Requests\Detail\Edit\EditMiddleValidate;
use Illuminate\Support\Collection;
use App\Middle;
use App\Classes\StorageCommon;

class MiddleFactory
{
    use FactoryHelper;

    static function fromName(Array $strs,String $column):Collection{
        //与えられた文字列でLike検索をする
        $middle=Middle::with(["parent_r:id,name,name_eng"]);//Eagerロード
        Search::find_Jap_or_Eng($middle,"m_middle",$strs,$column);
        return $middle->get();
    }

    static function getFromCategory(int $cid):Collection{
        //親IDからミドルカテゴリのコレクションを取得する
        return Middle::where("parent",$cid)->get();
    }

    static function getById(int $id):Middle{
        return Middle::find($id);
    }
    static function getByIdAndParent(int $id):Middle{
        return Middle::with(["parent_r"])->find($id);
    }

    public static function generateFromEditMiddleValidate(EditMiddleValidate $request):Middle{
        //EditBrandValidateクラスからインスタンスを生成する
        $middle=self::generateFromRequest(MIDDLE,$request);
        return $middle;
    }
}
