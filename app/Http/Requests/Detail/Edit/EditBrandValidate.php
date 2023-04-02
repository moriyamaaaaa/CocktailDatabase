<?php

namespace App\Http\Requests\Detail\Edit;

use Illuminate\Foundation\Http\FormRequest;

class EditBrandValidate extends FormRequest
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
            "id" => "nullable|numeric|min:1",
            "category" => "required|numeric|min:1",
            "middle" => "nullable|numeric|min:1",
            "name" => "required",
            "name_eng" => "required",
            "strength" => "required|numeric",
            "description" => "required",
            "youtube_time_hour" => "nullable|numeric|min:1",
            "youtube_time_minute" => "nullable|numeric|min:0|max:59",
            "youtube_time_second" => "nullable|numeric|min:0|max:59",
            "is_major" => "required|boolean",
            "is_like" => "required|boolean",
            "input_image" => "nullable|image",
        ];
    }
}
