<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'm_category';

    public function middle_r()
    {
        return $this->hasMany('App\Middle',"parent","id");
    }
    public function cocktail()
    {
        return $this->hasMany('App\Cocktail','base','id');
    }
    public function kind()
    {
        return $this->belongsTo("App\Kind","kind","id");
    }
}
