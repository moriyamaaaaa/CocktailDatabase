<?php

namespace App\Http\Resources\Admin;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserDataForVuex extends JsonResource
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
            'name'=>$this->name
        ];
    }
}
