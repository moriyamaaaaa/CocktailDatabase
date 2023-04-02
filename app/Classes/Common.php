<?php
namespace App\Classes;


use Illuminate\Support\Facades\Storage;

class Common
{
    static function getImageURL(string $str){
        return Storage::disk('public')->url("images/".$str);
    }
}
