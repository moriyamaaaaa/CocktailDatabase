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
use Illuminate\Support\Collection;
use App\Kind;
use DB;

class KindFactory
{
    static public function is_kind5_fromKindId(int $kind_id):bool{
        return $kind_id == 5 || $kind_id == 4;//「その他」の場合ばっか注視してたけど、そういやソフトドリンクも有名な銘柄要らんかったわ･･････
    }
    static public function is_kind5(Category $c):bool {
        return self::is_kind5_fromKindId($c->kind);
    }
    static public function is_kind5_fromCategory(int $categoryid):bool {
        return self::is_kind5(Category::find(($categoryid)));
    }

    static public function is_garnish_fromKindId(int $kind_id):bool{
        return $kind_id == 5;//「その他」の場合ばっか注視してたけど、そういやソフトドリンクも有名な銘柄要らんかったわ･･････
    }
    static public function is_garnish(Category $c):bool {
        return self::is_garnish_fromKindId($c->kind);
    }
}
