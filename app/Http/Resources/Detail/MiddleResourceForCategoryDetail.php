<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CocktailSearch\Children\CategoryInCocktailResource;
use App\Http\Resources\CocktailSearch\Children\MethodResource;

class MiddleResourceForCategoryDetail extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'name_eng'=>$this->name_eng,
            //'youtube'=>$this->youtube,
            //'is_powder'=>$this->is_powder,
            //'is_major'=>$this->is_major,
            'is_like'=>$this->is_like
        ];
    }
}
