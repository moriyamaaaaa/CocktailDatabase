<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 06:04
 */
namespace App\Classes\Factory;

use App\Classes\Rakuten;
use DB;
use App\Classes\Exceptions\RakutenNotFoundException;

class RakutenFactory
{
    static private function generateURL(string $keyword, bool $is_not_liqueur=false):String{
        $apkey = env("RAKUTEN_AP_KEY");
        $affID = env("RAKUTEN_AFFILIATE_ID");;
        $keyword = urlencode($keyword);
        $reqest = 'https://app.rakuten.co.jp/services/api/IchibaItem/Search/20170706?';
        $reqest.= 'applicationId='.$apkey;
        $reqest.= '&keyword='.$keyword;
        if(!$is_not_liqueur){
            $reqest.= '&genreId='."510915";
        }
        $reqest.= '&formatVersion=2&affiliateId='.$affID;

        return $reqest;
    }

    static public function generateFromWord(string $name):Rakuten{
        $options['ssl']['verify_peer'] = false;
        $options['ssl']['verify_peer_name'] = false;
        try{
            $get = file_get_contents(self::generateURL($name), false, stream_context_create($options));
        }catch(\ErrorException $e){
            //おそらく検索ワードにスペースが含まれているのでトリム「検索ワードは最低2文字、らしい」
            $get = file_get_contents(self::generateURL(str_replace(array(" ", "　"), "",$name )), false, stream_context_create($options));
            //ここでエラーが起きたら、ちょっとわからんので処理を止める
        }
        $response=json_decode($get);//レスポンスを取得
        $items=$response->Items;
        if(empty($items)){
            //検索結果なし
            throw new RakutenNotFoundException();
        }
        $item=$items[0];
        $rakuten=new Rakuten();
        $rakuten->set_searchURL($name);//検索結果URLは特殊なので生成
        $rakuten->set("detailURL",$item->affiliateUrl);
        if($item->imageFlag==1){
            $rakuten->set_imageURL($item->smallImageUrls[0]);
        }

        $rakuten->set("title",$item->itemName);
        $rakuten->set("price",$item->itemPrice);
        return $rakuten;
    }

}
