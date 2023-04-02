<?php

namespace App\Http\Requests\Detail\Edit;

use Illuminate\Foundation\Http\FormRequest;

class EditCocktailValidate extends FormRequest
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
    public function all($keys = null)
    {
       $results = parent::all($keys);

        foreach($results as $key=>$value){
            if($value==="null"||$value==="undefined"||$value===""){
                //空文字である
                $results[$key]=null;
            }elseif (is_numeric($value) && ctype_digit($value)){
                //$valueは整数である
                $results[$key]=(int)$value;
            }else if(is_numeric($value) && !ctype_digit($value)){
                //$valueは小数である
                $results[$key]=(float)$value;
            }else if($value==="true"||$value==="false"){
                //$valueはbooleanである
                $results[$key]=($value === 'true');
            }
        }

        return $results;
    }

    public function rules()
    {
        return [
            "id" => "nullable|integer|min:1",
            "base" => "required|integer|min:1",
            "name" => "required",
            "name_eng" => "required",//"null"というStringを許容はしない。FormDataではStringしか送信できないので追加する際はハードで更新しないといけなさそう。
            "sweet_degree" => "nullable|integer|min:-10|max:10",
            "rate" => "nullable|integer|min:1|max:5",
            "glass" => "nullable|integer|min:1",
            "ice" => "nullable|integer|min:1",
            "method" => "required|integer|min:1|max:6",
            "youtube_time_hour" => "nullable|integer|min:1",
            "youtube_time_minute" => "nullable|integer|max:59",
            "youtube_time_second" => "nullable|integer|max:59",
            //"is_major" => "required|boolean",
            "input_image" => "nullable|image",
            "recipes" => "array",
            "recipes.0.category" => "required|integer|min:1",
            "recipes.1.category" => "required|integer|min:1",
            "recipes.*.amount" => "required_with:recipes.*.category|required",
        ];
    }
}
