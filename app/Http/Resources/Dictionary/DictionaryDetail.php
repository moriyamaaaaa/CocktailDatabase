<?php

namespace App\Http\Resources\Dictionary;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DictionaryDetail extends JsonResource
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
            'description'=>Markup::generateDiscriptionArray($this->description),
            'dictionary_category'=>DictionaryCategoryForDetail::make($this->dictionary_category_r),
            'image'=>($this->image)?asset('storage/'.$this->image):null,
            'image_txt'=>$this->image_txt,
            'image_url'=>$this->image_url,
            'y_h'=>$this->y_hour,
            'y_m'=>$this->y_minute,
            'y_s'=>$this->y_second,
            'youtube'=>$this->youtube,
        ];
    }
}
