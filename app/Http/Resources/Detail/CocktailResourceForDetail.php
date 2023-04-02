<?php

namespace App\Http\Resources\Detail;

use App\Classes\Common;
use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\Children\MethodResource;
use App\Http\Resources\Detail\sub\GlassResourceForSub;
use App\Recipe;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Detail\sub\IceResourceForSub;

class CocktailResourceForDetail extends JsonResource
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
            'base'=>CategoryResourceForSub::make($this->base_r),
            'youtube'=>$this->youtube,
            'youtube_created_at'=>$this->youtube_created_at,
            'instagram'=>$this->instagram,
            'strength'=>$this->volume,
            'sweet_degree'=>$this->sweet_degree,
            'rate'=>$this->rate,
            'note'=>Markup::generateDiscriptionArray($this->note),
            'created_at'=>$this->created_at,
            'image'=>($this->image)?asset('storage/'.$this->image):null,
            'updated_at'=>$this->updated_at,
            'image_txt'=>$this->image_txt,
            'image_url'=>$this->image_url,
            'method'=>MethodResource::make($this->method_r),
            'glass'=>GlassResourceForSub::make($this->glass_r),
            'ice'=>IceResourceForSub::make($this->ice_r),
            'description'=>Markup::generateDiscriptionArray($this->description),
            'is_major'=>$this->is_major,
            'y_h'=>$this->y_hour,
            'y_m'=>$this->y_minute,
            'y_s'=>$this->y_second,

        ];
    }
}
