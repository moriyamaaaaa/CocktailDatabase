<?php

namespace App\Http\Requests\Detail;

use Illuminate\Foundation\Http\FormRequest;

class RegetCocktailValidate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "limit"=>"required|numeric|min:1",
            "category"=>"required_without_all:cocktail,base,method,glass|numeric|min:1",
            "middle"=>"numeric|min:1",
            "brand"=>"numeric|min:1",
            "cocktail"=>"required_without_all:category,base,method,glass|numeric|min:1",
            "base"=>"required_without_all:cocktail,category,method,glass|numeric|min:1",
            "method"=>"required_without_all:cocktail,category,base,glass|numeric|min:1|max:6",
            "glass"=>"required_without_all:cocktail,category,base,method|numeric|min:1",
        ];
    }
}
