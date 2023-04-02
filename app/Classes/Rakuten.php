<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2020-09-07
 * Time: 00:05
 */

namespace App\Classes;


class Rakuten
{
    private string $searchURL;
    private string $detailURL;
    private string $image_url;
    private string $title;
    private int $price;

    public function set($key,$value):Rakuten{
        $this->$key=$value;
        return $this;
    }

    function set_searchURL(string $word):Rakuten{
        //検索結果のURLを加工してセット
        $url="https://hb.afl.rakuten.co.jp/hgc/";
        $url.=env("RAKUTEN_AFFILIATE_ID")."/?pc=https%3A%2F%2Fsearch.rakuten.co.jp%2Fsearch%2Fmall%2F";
        $url.=urlencode($word);
        $url.="%2F510915%2F";
        $this->searchURL=$url;
        return $this;
    }

    function set_imageURL(string $url):Rakuten{
        //画像URLはオリジナルサイズを保持
        $this->image_url =strstr($url,'?_ex=',true);
        return $this;
    }

    function searchURL():String{
        return $this->searchURL;
    }

    function detailURL():String{
        return $this->detailURL;
    }
    function image_url():?String{
        return $this->image_url??null;
    }
    public function title():String{
        return $this->title;
    }
    function price():int{
        return $this->price;
    }
}
