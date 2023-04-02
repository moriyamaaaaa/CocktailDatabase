<?php

namespace App\Http\Controllers;

use App\Classes\Exceptions\AmazonNotFoundException;
use App\Classes\Factory\AffiliateFactory;
use App\Classes\Factory\AmazonFactory;
use App\Http\Requests\Detail\AffiliateValidate;
use App\Http\Resources\Detail\AffiliateResource;
use DB;
use App\Affiliate;
use App\Category;
use App\Middle;
use App\Brand;


class AffiliateController extends Controller
{
    public function main(){
        //メインフロー
        //作成済みアフィリエイトデータの最大値を調べる
        $maxBrandId=Affiliate::max('brand_id')??0;

        //親カテゴリ、ミドルカテゴリに関しては「有名銘柄IDなし」に限定
        $maxMiddleId=Affiliate::where("brand_id",0)->max('middle_id')??0;
        $maxCategoryId=Affiliate::where("brand_id",0)->max('category_id')??0;

        //カテゴリ、ミドルカテゴリ、銘柄について、未収集分のデータを持ってくる
        $categories=Category::where("id",">",$maxCategoryId)->whereNull("famous_brand_id")->get();
        $middles=Middle::where("id",">",$maxMiddleId)->whereNull("famous_brand_id");

        $brands=Brand::where("id",">",$maxBrandId)->get();

        //古いデータは再取得
        $oldAffiliates=Affiliate::where("updated_at","<",(new \DateTime())->modify("-7 days"))->whereNull("human_price")->take(5)->get();

        //dump($oldAffiliates);

        foreach([$brands,$middles,$categories,$oldAffiliates] as $collection){
            foreach($collection as $instance){
                switch (get_class($instance)){
                    case "App\Brand":
                        $affiliate=AffiliateFactory::createAndSearchFromBrand($instance);
                        break;
                    case "App\Middle":
                        $affiliate=AffiliateFactory::createAndSearchFromMiddle($instance);
                        $affiliate->brand_id=0;//主キーゆえnullが指定不可
                        break;
                    case "App\Category":
                        $affiliate=AffiliateFactory::createAndSearchFromCategory($instance);
                        $affiliate->middle_id=0;
                        $affiliate->brand_id=0;
                        break;
                    case "App\Affiliate":
                        if($instance->brand_id!=0){
                            $affiliate=AffiliateFactory::createAndSearchFromBrand(Brand::find($instance->brand_id));
                        }else if($instance->middle_id!=0){
                            $affiliate=AffiliateFactory::createAndSearchFromMiddle(Middle::find($instance->middle_id));
                            $affiliate->brand_id=0;//主キーゆえnullが指定不可
                        }else{
                            $affiliate=AffiliateFactory::createAndSearchFromCategory(Category::find($instance->category_id));
                            $affiliate->middle_id=0;
                            $affiliate->brand_id=0;
                        }

                        //$affiliate=AffiliateFactory::update($instance);
                        DB::table("affiliates")
                            ->where("category_id",$instance->category_id)
                            ->where("middle_id",$instance->middle_id)
                            ->where("brand_id",$instance->brand_id)
                            ->delete();//Eloquentだとエラーが出るので仕方なく
                        break;
                }
                //データが完成したのでDBに挿入
                $affiliate->updated_at=new \DateTime();
                $affiliate->save();

                usleep(1000000 * 1);//API制限を回避したいので1秒待つ
            }
        }
    }

    public function getAffiliateData(AffiliateValidate $request){
        $category_id=$request->input("category_id");
        $middle_id=$request->input("middle_id");
        $brand_id=$request->input("brand_id");

        if(!empty($brand_id)){
            //銘柄データがあれば、それを元に検索すればよい
            $affiliate=Affiliate::where("brand_id",$brand_id)->first();

        }else if(!empty($middle_id)){
            $famous_brand_id=Middle::where("id",$middle_id)->value("famous_brand_id");
            if(!empty($famous_brand_id)){
                $affiliate=Affiliate::where("brand_id",$famous_brand_id)->first();
            }else{
                $affiliate=Affiliate::where("middle_id",$middle_id)
                    ->first();
            }
        }else{
            $famous_brand_id=Category::where("id",$category_id)->value("famous_brand_id");
            if(!empty($famous_brand_id)){
                $affiliate=Affiliate::where("brand_id",$famous_brand_id)->first();
            }else{
                $affiliate=Affiliate::where("category_id",$category_id)
                    ->first();
            }
        }

        if(empty($affiliate)){
            //まだアフィリエイトデータが未作成だった場合
            throw new \Exception("アフィリエイトデータ未作成、もしくはDB接続失敗");
        }
        return[
            "result"=>AffiliateResource::make($affiliate),
        ];
    }
}




