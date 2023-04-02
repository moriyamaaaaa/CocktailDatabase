<?php

namespace App\Http\Resources\Admin\Detail;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BrandResourceForEdit extends JsonResource
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
            'category' => $this->category,
            'middle_category' => $this->middle_category,
            'name' => $this->name,
            'name_eng'=>$this->name_eng,
            'youtube'=>$this->youtube,
            'strength'=>$this->volume,
            'description'=>Markup::at_id_append_note($this->description),
            //'is_powder'=>$this->is_powder,
            'is_major'=>(bool)$this->is_major,
            'is_like'=>(bool)$this->is_like,
            'youtube'=>$this->youtube,
            'y_hour'=>$this->y_hour,
            'y_minute'=>$this->y_minute,
            'y_second'=>$this->y_second,
            //'image'=>($this->image)?env("MIX_SENTRY_DSN_PUBLIC_WITH_COCKTAIL").Storage::url('images/'.$this->image):null,
            'image'=>($this->image)?asset('storage/'.$this->image):null,
            'image_txt'=>$this->image_txt,
            'image_url'=>$this->image_url,
        ];
    }
}
