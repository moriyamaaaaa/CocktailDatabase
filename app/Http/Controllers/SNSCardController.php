<?php

namespace App\Http\Controllers;

use App\Affiliate;
use App\Classes\Markup;
use App\Cocktail;
use DB;
use App\Category;
use App\Middle;
use App\Brand;


class SNSCardController extends Controller
{
static function displayHTML($data){
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>宅飲みカクテルデータベース</title>
    <!-- Google / Search Engine Tags -->
    <meta itemprop="name" content="<?php echo $data->title; ?>">
    <meta itemprop="description" content="<?php echo $data->discription; ?>">
    <meta itemprop="image" content="<?php echo $data->img_url; ?>">
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="<?php echo $data->url; ?>">
    <meta property="og:type" content="website">
    <meta property="og:title" content="<?php echo $data->title; ?>">
    <meta property="og:description" content="<?php echo $data->discription; ?>">
    <meta property="og:image" content="<?php echo $data->img_url; ?>">
    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary">
    <!--<meta name="twitter:card" content="summary_large_image">-->
    <meta name="twitter:title" content="<?php echo $data->title; ?>">
    <meta name="twitter:description" content="<?php echo $data->discription; ?>">
    <meta name="twitter:image" content="<?php echo $data->img_url; ?>">
</head>
</html>
<?php
}

    public function display(String $command,int $id){
        $data=new \stdClass();
        $data->img_url="";//なんかもうめんどくさいので定義しておく。
        $data->url=env("APP_URL")."/detail/".$command."/".$id;//laravel側のルーティングと連動してないので、仕方なく直打ちで。
        //URLの名前によって分岐
        switch ($command){
            case "cocktail":
            case "Cocktail":
                $instance=Cocktail::find($id);
                break;
            case "category":
            case "Category":
                $instance=Category::find($id);
                break;
            case "middle":
            case "Middle":
                $instance=Middle::find($id);
                break;
            case "brand":
            case "Brand":
                $instance=Brand::find($id);
                break;
        }
        if(!empty($instance)){
            //インスタンスが取得できた場合(つまり各論ページの場合)
            $data->title=$instance->name." | 宅飲みカクテルデータベース";
            $data->discription=Markup::generateDiscriptionStr($instance->description);

            //画像は特殊な処理を噛ます必要がある
            //設定されている場合はそれを表示すればOK
            if(!empty($instance->image)){
                $data->img_url=asset('storage/'.$instance->image);
            }else{
                //画像が設定されていない場合、アフィリエイトデータから取得
                switch (get_class($instance)) {
                    case "App\Category":
                        $affiliate=Affiliate::where("category_id",$instance->id)->where("brand_id",
                            (!empty($instance->famous_brand_id))?$instance->famous_brand_id:0
                        )->first();
                        break;
                    case "App\Middle":
                        $affiliate=Affiliate::where("middle_id",$instance->id)->where("brand_id",
                            (!empty($instance->famous_brand_id))?$instance->famous_brand_id:0
                        )->first();
                        break;
                    case "App\Brand":
                        $affiliate=Affiliate::where("brand_id",$instance->id)->first();
                        break;
                }
                if(!empty($affiliate)){
                    $data->img_url=$affiliate->getImgURL();
                }
            }
        }else{
            //detailページではなく、トップページ等である場合(そもそもアドレスを正規表現で取得しづらいので、現状ここには到達しない想定)
            $data->title="宅飲みカクテルデータベース";
            $data->discription="読んで楽しい、を目指して作ったお酒のデータベース。";
        }

        self::displayHTML($data);

        return;
    }


}




