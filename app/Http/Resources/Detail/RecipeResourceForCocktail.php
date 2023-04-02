<?php

namespace App\Http\Resources\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class RecipeResourceForCocktail extends JsonResource
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
            'category'=>CategoryResourceForSub::make($this->base_r),
            'middle'=>MiddleResourceForCategoryDetail::make($this->middle_r),
            'brand'=>BrandResourceForSub::make($this->brand_r),
            "amount"=>$this->amount,
            "is_optional"=>$this->is_optional
        ];
    }
}
