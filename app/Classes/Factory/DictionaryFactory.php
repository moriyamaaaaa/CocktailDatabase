<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 06:04
 */
namespace App\Classes\Factory;

use App\Dictionary;
use App\DictionaryCategory;
use Illuminate\Support\Collection;
class DictionaryFactory
{
    static function getById(int $id):Dictionary{
        return Dictionary::find($id);
    }

    static function getIndex():Collection{
        return DictionaryCategory::with(["dictionary_r"])->get();
    }

    static function getGlasses():Collection{
        return Dictionary::where("category",2)->get();
    }
}
