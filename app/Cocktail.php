<?php
/**
 * Created by PhpStorm.
 * User: a
 * Date: 2019-08-25
 * Time: 05:04
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class Cocktail extends Model
{
    protected $table = 't_cocktails';

    public function isDraft(bool $isDraft){
        return $this->where("is_draft",(int)$isDraft);
    }

    public function base_r()
    {
        return $this->belongsTo('App\Category','base','id');
    }
    public function recipe_r()
    {
        return $this->hasMany('App\Recipe','cocktail_id','id');
    }

    public function method_r(){
        return $this->belongsTo('App\Method','method','id');
    }

    public function glass_r(){
        return $this->belongsTo('App\Dictionary','glass','id');
    }
    public function ice_r(){
        return $this->belongsTo('App\Ice','ice','id');
    }
}
