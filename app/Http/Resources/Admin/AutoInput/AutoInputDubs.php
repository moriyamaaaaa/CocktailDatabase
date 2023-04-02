<?php

namespace App\Http\Resources\Admin\AutoInput;

use App\Classes\Markup;
use App\Http\Resources\Admin\Detail\RecipeResourceForEdit;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AutoInputDubs extends JsonResource
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
            'method' => $this->method,
            'name' => $this->name,
            'name_eng'=>$this->name_eng,
            'sweet_degree'=>$this->sweet_degree,
            'rate'=>$this->rate,
            'note'=>Markup::at_id_append_note($this->note),
            'description'=>Markup::at_id_append_note($this->description),
            'is_draft'=>$this->is_draft,

            "recipes"=>RecipeResourceForEdit::collection($this->recipe_r)
        ];
    }
}
