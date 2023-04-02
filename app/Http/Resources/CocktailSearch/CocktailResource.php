<?php

namespace App\Http\Resources\CocktailSearch;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CocktailSearch\Children\CategoryInCocktailResource;
use App\Http\Resources\CocktailSearch\Children\MethodResource;

class CocktailResource extends JsonResource
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
            'youtube'=>$this->youtube,
            'strength'=>$this->volume,
            'sweet_degree'=>$this->sweet_degree,
            'rate'=>$this->rate,
            //'glass'=>$this->glass,
            'updated_at'=>$this->updated_at,
            'is_major'=>$this->is_major,
            'base'=>CategoryInCocktailResource::make($this->base_r),
            'method'=>MethodResource::make($this->method_r),
            "recipe_count"=>$this->recipe_count
        ];
    }
}
