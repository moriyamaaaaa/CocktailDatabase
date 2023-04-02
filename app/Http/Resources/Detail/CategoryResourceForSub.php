<?php

namespace App\Http\Resources\Detail;

use App\Classes\Markup;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResourceForSub extends JsonResource
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
            //'description'=>Markup::generateDiscriptionArray($this->description),
            //'is_powder'=>$this->is_powder,
            //'is_major'=>$this->is_major,
            //'is_like'=>$this->is_like
        ];
    }
}
