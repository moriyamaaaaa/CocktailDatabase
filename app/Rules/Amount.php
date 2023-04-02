<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Amount implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public static $regex="/^(([1-9][0-9]*)[.\/]?[0-9]*(m|ml|oz|da|dr|dash|drop|t|tsp|g|個|片|cup)?|少量|-|適量)$/";
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */

    public function passes($attribute, $value)
    {
        //if (preg_match("/^(([1-9][0-9]*)[.\/]?[0-9]*(m|ml|oz|da|dr|dash|drop|t|tsp|g)?|少量|-|適量|[1-9][0-9]*\/[1-9][0-9]*|[1-9][0-9]*\/?[1-9]?[0-9]*個)$/", $value)) {
        if (preg_match(self::$regex, $value)) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.regex');
    }
}
