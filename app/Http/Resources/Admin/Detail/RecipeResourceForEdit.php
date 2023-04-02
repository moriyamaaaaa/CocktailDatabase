<?php

namespace App\Http\Resources\Admin\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class RecipeResourceForEdit extends JsonResource
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
            'category' => $this->category,
            'category_name' => $this->base_r->name,
            'middle' => $this->middle_category,
            'middle_name' => ($this->middle_r)?$this->middle_r->name:null,
            'brand' => $this->brand,
            'brand_name' => ($this->brand_r)?$this->brand_r->name:null,
            'amount' => $this->amount,
            'is_optional' => (bool)$this->is_optional,
        ];
    }
}
