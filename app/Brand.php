<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = 'm_brand';

    public function middle_r()
    {
        return $this->belongsTo('App\Middle','middle_category','id');
    }
    public function parent_r()
    {
        return $this->belongsTo('App\Category','category','id');
    }


}
