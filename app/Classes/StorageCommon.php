<?php 

namespace App\Classes;

use App\Brand;
use App\Category;
use App\Classes\Factory\CategoryFactory;
use App\Classes\Factory\CocktailFactory;
use App\Classes\Factory\DictionaryFactory;
use App\Classes\Factory\MiddleFactory;
use App\Classes\Factory\BrandFactory;
use App\Cocktail;
use App\Dictionary;
use App\Middle;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;

class StorageCommon{
    static public function saveFromDetailAdmin($file,String $alreadyFileName=null){
        if (!Auth::check()) {
            // さすがにログインしていない状態でいじるのはやめてくれ(笑)
            abort("403");
        }
        $path = $file->store("public");

        $filename = basename($path);//ファイル名だけ抜き出す
        if($alreadyFileName){
            //すでに登録されているのに配信されたので、ストレージから消す
            //Storage::delete('images/'.$brand->image);
            Storage::delete("public/".$alreadyFileName);
        }
        return $filename;//旧ファイルは削除できたので、新ファイルをDBに格納したい
    }

}
