<?php

namespace App\Http\Requests\Detail\Edit;

use App\Classes\Factory\KindFactory;
use Illuminate\Foundation\Http\FormRequest;

class EditMiddleValidate extends FormRequest
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
        $return=[
            "id" => "nullable|numeric|min:1",
            "category" => "required|numeric|min:1",
            "name" => "required",
            "name_eng" => "required",
            "description" => "required",
            "youtube_time_hour" => "nullable|numeric|min:1",
            "youtube_time_minute" => "nullable|numeric|min:0|max:59",
            "youtube_time_second" => "nullable|numeric|min:0|max:59",
            "is_major" => "required|boolean",
            "is_like" => "required|boolean",
            "is_powder" => "required|boolean",
            "input_image" => "nullable|image",
            "brand_id"=>'nullable|numeric|min:1'];
        $brandValids=[
            "brand_name"=>"required_without:brand_id",
            "brand_name_eng"=>"required_without:brand_id",
            "brand_strength" => "required_without:brand_id|numeric",
            "brand_description" => "required_without:brand_id",
            "brand_youtube_time_hour" => "nullable|numeric|min:1",
            "brand_youtube_time_minute" => "nullable|numeric|max:59",
            "brand_youtube_time_second" => "nullable|numeric|max:59",
            "brand_is_major" => "required_without:brand_id|boolean",
            "brand_is_like" => "required_without:brand_id|boolean",
            "brand_input_image" => "nullable|image",
        ];
        if(KindFactory::is_kind5_fromCategory($this->category)===true){
            $this->is_kind5=true;
            //「その他」カテゴリの場合、必要事項が何かしら記入されていたらブロック
            if(
                !empty($this->brand_name)
            || !empty($this->brand_name_eng)
            || !empty($this->brand_strength)
            || !empty($this->brand_description)
            ){
                $return+=$brandValids;
            }
        }else{
            $return+=$brandValids;
        }

        return $return;
    }
}
