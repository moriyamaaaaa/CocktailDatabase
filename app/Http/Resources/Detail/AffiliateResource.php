<?php

namespace App\Http\Resources\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AffiliateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'category_id' => $this->category_id,
            'middle_id' => $this->middle_id,
            'brand_id'=>$this->brand_id,
            'name'=>$this->name,
            'title'=>$this->title,
            'price'=>$this->price,
            'img_large_url'=>$this->img_large_url,
            'img_medium_url'=>$this->img_medium_url,
            'img_small_url'=>$this->img_small_url,
            'human_image_url'=>$this->human_image_url,
            'amazon_detail_url'=>$this->amazon_detail_url,
            'amazon_search_url'=>$this->amazon_search_url,
            'human_amazon_detail_url'=>$this->human_amazon_detail_url,
            'human_amazon_search_url'=>$this->human_amazon_search_url,
            'human_price'=>$this->human_price,
            'human_title'=>$this->human_title,
            'rakuten_title'=>$this->rakuten_title,
            'rakuten_price'=>$this->rakuten_price,
            'rakuten_detail_url'=>$this->rakuten_detail_url,
            'rakuten_search_url'=>$this->rakuten_search_url,
            'rakuten_image_url'=>$this->rakuten_image_url,
            'updated_at'=>(new \DateTime($this->updated_at))->format('Y/m/d')
        ];
    }
}
