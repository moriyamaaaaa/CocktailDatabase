<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $table = 't_recipies';
    public $timestamps = false;

    public function base_r()
    {
        return $this->belongsTo('App\Category','category','id');
    }

    public function middle_r()
    {
        return $this->belongsTo('App\Middle','middle_category','id');
    }
    public function brand_r()
    {
        return $this->belongsTo('App\Brand','brand','id');
    }

}
