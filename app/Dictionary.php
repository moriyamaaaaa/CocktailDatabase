<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Dictionary extends Model
{
    protected $table = 't_dictionary';

    public function dictionary_category_r()
    {
        return $this->belongsTo("App\DictionaryCategory","category","id");
    }
}
