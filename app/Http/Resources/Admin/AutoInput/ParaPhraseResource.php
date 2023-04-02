<?php

namespace App\Http\Resources\Admin\AutoInput;

use App\Classes\Markup;
use App\Http\Resources\CocktailSearch\children\MethodResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ParaPhraseResource extends JsonResource
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
            'name' => $this->name,
            'converted' => $this->converted,
            'middle' => $this->middle,
            'note' => $this->note,
            'command' => (!empty($this->command))?$this->command:"",$this->command,
        ];
    }
}
