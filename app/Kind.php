<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Kind extends Model
{
    protected $table = 'm_category_kinds';

    public function categories()
    {
        return $this->hasMany('App\Category','id','kind');
    }

}
