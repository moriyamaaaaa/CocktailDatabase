<?php

namespace App\Http\Resources\FromNameSearch;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CocktailSearch\Children\CategoryInCocktailResource;//流用
use App\Http\Resources\FromNameSearch\MiddleOnlyResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if(empty($this->id))return null;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'name_eng' => $this->name_eng,
            'category'=>CategoryInCocktailResource::make($this->parent_r),
            'middle'=>MiddleOnlyResource::make($this->middle_r),
            'youtube'=>$this->youtube,
            'volume'=>$this->volume
        ];
    }
}
