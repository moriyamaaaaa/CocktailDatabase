<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 06:04
 */
namespace App\Classes\Factory;

use App\Classes\Amazon;
use App\Classes\Exceptions\AmazonNotFoundException;
use DB;

use Revolution\Amazon\ProductAdvertising\Facades\AmazonProduct;

class AmazonFactory
{
    static public function searchForAmazon(string $word):Amazon{

    }

    static public function generateFromWord(string $name):Amazon{
        $response=AmazonProduct::search('GroceryAndGourmetFood', $name , 1);//食料品から$nameを検索し、最初の1ページを取得
        if(isset($response["Errors"][0]["Code"]) && $response["Errors"][0]["Code"]=="NoResults"){
            //検索結果なし
            throw new AmazonNotFoundException();
        }
        $result=$response["SearchResult"];//実体
        $item=$result["Items"][0];//必要なアイテム

        //なんかよくわからんデータを引っ張ってたらヒットしない扱い
        if(!isset($item["Offers"])){throw new AmazonNotFoundException();}

        $amazon=new Amazon();
        $amazon->set("searchURL",$result["SearchURL"]);
        $amazon->set("detailURL",$item["DetailPageURL"]);
        $amazon->set("image_url_small",$item["Images"]["Primary"]["Small"]["URL"]);
        $amazon->set("image_url_medium",$item["Images"]["Primary"]["Medium"]["URL"]);
        $amazon->set("image_url_large",$item["Images"]["Primary"]["Large"]["URL"]);
        $amazon->set("title",$item["ItemInfo"]["Title"]["DisplayValue"]);
        $amazon->set("price",$item["Offers"]["Listings"][0]["Price"]["Amount"]);

        return $amazon;
    }

}
