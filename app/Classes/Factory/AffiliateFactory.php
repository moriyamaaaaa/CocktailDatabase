<?php


namespace App\Classes\Factory;


use App\Affiliate;
use App\Brand;
use App\Category;
use App\Classes\Exceptions\AmazonNotFoundException;
use App\Classes\Exceptions\RakutenNotFoundException;
use App\Middle;

class AffiliateFactory
{
    private static function exeSearch(Affiliate $affiliate,string $word):Affiliate{
        //検索の実体
        $affiliate->init();//初期化

        //アフィリエイトデータを収集するためAPIを叩く
        try{
            $amazon=AmazonFactory::generateFromWord($word);

            //見つかったので、アフィリエイトデータを挿入
            $affiliate->appendFromAmazon($amazon);

        }catch (AmazonNotFoundException $e){
            //
        }

        //楽天を用いて検索
        try{
            $is_not_liqueur=Category::find($affiliate->category_id)->value("kind")>=4;//kindが4以上ならば洋酒ではない
            $rakuten=RakutenFactory::generateFromWord($word,$is_not_liqueur);
            $affiliate->appendFromRakuten($rakuten);
        }catch(RakutenNotFoundException $e){
            //検索だけ追加しておく？(画像が拾ってこれないので保留)
        }
        //Amazonでも楽天でも見つからなかったばあい、空データとして処理
        return $affiliate;
    }

    public static function createFromCategory(Category $category):Affiliate{
        $affiliate=new Affiliate();
        $affiliate->name=$category->name;
        $affiliate->category_id=$category->id;
        return $affiliate;
    }

    public static function createFromMiddle(Middle $middle):Affiliate{
        $affiliate=new Affiliate();
        $affiliate->name=$middle->name;
        $affiliate->category_id=$middle->parent;
        $affiliate->middle_id=$middle->id;
        return $affiliate;
    }

    public static function createFromBrand(Brand $brand):Affiliate{
        $affiliate=new Affiliate();
        $affiliate->name=$brand->name;
        $affiliate->category_id=$brand->category;
        $affiliate->middle_id=$brand->middle_category??0;
        $affiliate->brand_id=$brand->id;
        return $affiliate;
    }

    public static function createAndSearchFromCategory(Category $category):Affiliate{
        $affiliate=self::exeSearch(self::createFromCategory($category),$category->name);
        return $affiliate;
    }
    public static function createAndSearchFromMiddle(Middle $middle):Affiliate{
        $affiliate=self::exeSearch(self::createFromMiddle($middle),$middle->name);
        return $affiliate;
    }
    public static function createAndSearchFromBrand(Brand $brand):Affiliate{
        $affiliate=self::exeSearch(self::createFromBrand($brand),$brand->name);
        return $affiliate;
    }
    public static function update(Affiliate $affiliate):Affiliate{
        return self::exeSearch($affiliate,$affiliate->name);
    }
}
