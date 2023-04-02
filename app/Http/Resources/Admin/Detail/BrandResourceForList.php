<?php

namespace App\Http\Resources\Admin\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResourceForList extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //dump($this);
        //dump($this->parent_r->name);
        //dump(($this->middle_category!=null)?"/".$this->middle_r->name:"");
        if($this->middle_category!=null){
            $middle_name=$this->middle_r->name;
            $middleFamousId=$this->middle_r->famous_brand_id;
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_eng'=>$this->name_eng,
            'category_id'=>$this->category,
            'category_name'=>$this->parent_r->name,
            'middle_name'=>$middle_name??null,
            'categorys_famous_id'=>$this->parent_r->famous_brand_id,
            'middles_famous_id'=>$middleFamousId??null
        ];
    }
}
