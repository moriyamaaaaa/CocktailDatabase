<?php

namespace App\Http\Resources\Admin\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CocktailResourceForEdit extends JsonResource
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
            'base' => $this->base,
            'middle_category' => $this->middle_category,
            'name' => $this->name,
            'name_eng'=>$this->name_eng,
            'youtube'=>$this->youtube,
            'description'=>Markup::at_id_append_note($this->description),
            'is_major'=>(bool)$this->is_major,
            'sweet_degree'=>$this->sweet_degree,
            'rate'=>$this->rate,
            'note'=>Markup::at_id_append_note($this->note),
            'method'=>$this->method,
            'glass'=>$this->glass,
            'ice'=>$this->ice,
            'y_hour'=>$this->y_hour,
            'y_minute'=>$this->y_minute,
            'y_second'=>$this->y_second,
            'image'=>($this->image)?asset('storage/'.$this->image):null,
            'image_txt'=>$this->image_txt,
            'image_url'=>$this->image_url,
        ];
    }
}
