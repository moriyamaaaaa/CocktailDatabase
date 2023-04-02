<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class DictionaryCategory extends Model
{
    protected $table = 'm_dictionary_category';

    public function dictionary_r()
    {
        return $this->hasMany('App\Dictionary','category','id');
    }
}
