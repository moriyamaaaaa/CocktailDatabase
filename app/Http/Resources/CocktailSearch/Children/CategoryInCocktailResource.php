<?php

namespace App\Http\Resources\CocktailSearch\Children;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryInCocktailResource extends JsonResource
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
            'base_id' => $this->id,
            'base_name' => $this->name,
            'base_eng'=>$this->name_eng
        ];
    }
}
