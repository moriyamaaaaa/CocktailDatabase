<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use App\Classes\Amazon;
use Illuminate\Database\Eloquent\Model;
use App\Classes\Rakuten;

class Affiliate extends Model
{
    protected $table = 'affiliates';
    //protected $primaryKey = ['category_id', 'middle_id','brand_id'];
    //public $incrementing = false;

    function init():Affiliate{
        $this->title = null;
        $this->price = null;
        $this->img_large_url =null;
        $this->img_medium_url = null;
        $this->img_small_url = null;
        $this->amazon_detail_url = null;
        $this->amazon_search_url = null;
        $this->updated_at = null;
        return $this;
    }

    function appendFromAmazon(Amazon $amazon):Affiliate
    {
        $this->title = $amazon->title();
        $this->price = $amazon->price();
        $this->img_large_url = $amazon->image_url_large();
        $this->img_medium_url = $amazon->image_url_medium();
        $this->img_small_url = $amazon->image_url_small();
        $this->amazon_detail_url = $amazon->detailURL();
        $this->amazon_search_url = $amazon->searchURL();

        return $this;
    }

    function appendFromRakuten(Rakuten $rakuten):Affiliate
    {
        $this->rakuten_title = $rakuten->title();
        $this->rakuten_price = $rakuten->price();
        $this->rakuten_image_url = $rakuten->image_url();
        $this->rakuten_detail_url = $rakuten->detailURL();
        $this->rakuten_search_url = $rakuten->searchURL();

        return $this;
    }

    function getImgURL(){
        if (!empty($this->human_image_url)){return $this->human_image_url;}
        if (!empty($this->img_medium_url)){return $this->img_medium_url;}
        if (!empty($this->rakuten_image_url)){return $this->rakuten_image_url;}
        return null;
    }
}
