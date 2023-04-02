<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Middle extends Model
{
    protected $table = 'm_middle';

    public function parent_r()
    {
        return $this->belongsTo('App\Category','parent','id');
    }
}
