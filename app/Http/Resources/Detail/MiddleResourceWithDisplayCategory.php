<?php

namespace App\Http\Resources\Detail;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CocktailSearch\Children\CategoryInCocktailResource;

class MiddleResourceWithDisplayCategory extends JsonResource
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
            'parent_name'=>$this->parent_r->name,
            'parent_name_eng'=>$this->parent_r->name_eng,
            'name_eng'=>$this->name_eng,
            //'category'=>CategoryInCocktailResource::make($this->parent_r),
        ];
    }
}
