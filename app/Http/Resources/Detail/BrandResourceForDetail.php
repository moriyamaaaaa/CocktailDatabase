<?php

namespace App\Http\Resources\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResourceForDetail extends JsonResource
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
            'description'=>Markup::generateDiscriptionArray($this->description),
            //'is_powder'=>$this->is_powder,
            'is_major'=>$this->is_major,
            'is_like'=>$this->is_like,
            'image'=>($this->image)?asset('storage/'.$this->image):null,
            'image_txt'=>$this->image_txt,
            'image_url'=>$this->image_url,
            'y_h'=>$this->y_hour,
            'y_m'=>$this->y_minute,
            'y_s'=>$this->y_second,
        ];
    }
}
