<?php

namespace App\Http\Requests\Search;

use Illuminate\Foundation\Http\FormRequest;

class SearchCocktail extends FormRequest
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
            "searchMethod"=>"required",
            "isEasily"=>"required|boolean",
            "Method"=>"required|array",//本当はnumericArrayなんかを定義したほうがいいんだろうけどね...
            "Category"=>"required|array",
            "Middle"=>"array"
        ];
    }
}
