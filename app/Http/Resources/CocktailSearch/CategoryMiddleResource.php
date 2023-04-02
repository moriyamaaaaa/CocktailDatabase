<?php

namespace App\Http\Resources\CocktailSearch;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FromNameSearch\MiddleOnlyResource;
use App\Http\Resources\CocktailSearch\KindResource;

class CategoryMiddleResource extends JsonResource
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
            'middle'=>MiddleOnlyResource::collection( $this->middle_r ),
            'kind'=>$this->kind,
            'isMajor'=>$this->is_major
            //'kind'=>KindResource::make( $this->kind ),
        ];
    }
}
