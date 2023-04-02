<?php

namespace App\Http\Requests\Detail\Edit;

use Illuminate\Foundation\Http\FormRequest;

class DuplicateGetValidate extends FormRequest
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
            "name" => "required_without:name_eng",
            "name_eng" => "required_without:name",
            "removeId"=>"nullable|integer|min:1"
        ];
    }
}
