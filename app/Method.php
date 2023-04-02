<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    protected $table = 'm_method';

    public function cocktails()
    {
        return $this->hasMany('App\Cocktail','method','id');
    }

}
