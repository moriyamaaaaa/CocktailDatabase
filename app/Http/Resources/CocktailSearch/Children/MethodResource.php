<?php

namespace App\Http\Resources\CocktailSearch\Children;

use Illuminate\Http\Resources\Json\JsonResource;

class MethodResource extends JsonResource
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
            'method_id' => $this->id,
            'method_name' => $this->name,
            'method_eng' => $this->name_eng,
        ];
    }
}
