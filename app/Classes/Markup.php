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

define("CATEGORY_PREG",     '/生クリーム|砂糖|紹興酒|梅酒|日本酒|焼酎|番茶|食塩|卵|桃|巨峰|グラニュー糖|食塩|玉ねぎ|乳酸飲料|桜の花|梅|生姜|醤油|酢/u');
define("MIDDLE_PREG",     '/(芋|麦|米|甲類)焼酎|(赤|白)ワイン|卵黄|卵白|角砂糖/u');

class Markup{
    static private function command(){
        return "cCbBpPmMdD";
    }
    static private function command_preg(){
        return "/@[".self::command()."][1-9][0-9]*@/";
    }
    static private function command_preg_without_a(){
        return "/[".self::command()."][1-9][0-9]*/";
    }
    static public function convert_to_name_search(String $str):string{
        //「・」を削除する(半角カナも追加した)
        return mb_convert_kana(str_replace('・', '', str_replace(' ', '', str_replace('.', '', $str))),'rn');
    }




    //メイン呼び出しメソッド
    public static function mark_up(string $str=null){
        //自動でマークアップを施す。
        if(empty($str)){return $str;}//空ならばそのまま返す
        $converted= self::convert_at_id($str);//まず明示的なマークアップを全て変換する。
        //
        //カタカナのみの羅列はマークアップできる可能性があるため検索。
        $result=preg_replace_callback(
            '/[ァ-ヶ][ァ-ヶ・ー]+/u',
            function ($matches) {
                $search=$matches[0];//カタカナの羅列が見つかった
                //逐一検索してみましょう。
                $name_search=self::convert_to_name_search($search);

                //まずはカテゴリ
                $id=Category::Where("name_search", "=",$name_search )->value("id");
                if($id!=null){return "@p".$id."@";}

                //次にカクテル
                $id=Cocktail::where("name_search", "=", $name_search)->value("id");
                if($id!=null){return "@c".$id."@";}

                //次にミドルカテゴリ
                $id=Middle::where("name_search", "=", $name_search)->value("id");
                if($id!=null){return "@m".$id."@";}

                //最後に銘柄
                $id=Brand::where("name_search", "=", $name_search)->value("id");
                if($id!=null){return "@b".$id."@";}

                //追加で辞典
                $id=Dictionary::where("name_search", "=", $name_search)->value("id");
                if($id!=null){return "@d".$id."@";}

                return $search;//見つからなければそのまま
            },
            //メインカテゴリ
            preg_replace_callback(CATEGORY_PREG,function ($matches) {
                $id=Category::where("name_search", "=", self::convert_to_name_search($matches[0]))->value("id");
                return "@p".$id."@";
            },
                //ミドルカテゴリ
                preg_replace_callback(MIDDLE_PREG, function ($matches) {
                    $id=Middle::Where("name_search", "=", self::convert_to_name_search($matches[0]))->value("id");
                    return "@m".$id."@";
                },
                $converted)
            )
         );
        return $result;
    }

    static function convert_at_id(string $str=null){
        //@[パラメータ][名前]@を@[パラメータ]「ID」@に変換する。見つからなければエラーを返す。(Ajax対応)
    if($str==null){return null;}
    if(preg_match('/@[a-zA-Z][^@]*$/',$str,$matches)){
        if(ctype_digit($matches[0][2])){
            throw new \Exception("マークアップが閉じられていません。:".$matches[0]);
        }//@?の後に数字が続かなければ、そもそもマークアップの意思がなかったと判断することにした
      }
    return  preg_replace_callback(
        '/@[a-zA-Z][^@]+@/',
        function ($matches) {
            $search = substr ($matches[0] , 2 ,-1 );//@とパラメータを除いた文字列を取得
            if(is_numeric($search)){return $matches[0];}//IDが指定されていた場合はそのままにする
            //データベースから名前を検索して置換する
            $command = substr ($matches[0] , 1 ,1 );//先頭の@を除いた1文字
            //現状は英語に対応しないことにした(B-52とかややこしくなるので)

            $name_search=self::convert_to_name_search($search);//先に変換しておく
            if($command === "c" ||$command ==="C"){
                //カクテルの場合
                $id=Cocktail::where("name_search",$name_search)->value("id");
            }else if($command ==="p" ||$command ==="P"){
                //カテゴリの場合
                $id=Category::where("name_search", $name_search);
            }else if($command ==="m" ||$command ==="M"){
                //ミドルカテゴリの場合
                $id= Middle::where("name_search", $name_search)->value("id");
            }else if($command ==="b" ||$command ==="B"){
                //銘柄の場合
                $id= Brand::where("name_search", $name_search)->value("id");
            }else if($command ==="d" ||$command ==="D"){
                //銘柄の場合
                $id= Dictionary::where("name_search",$name_search)->value("id");
            }else{
                throw new \Exception("コマンドが間違っています:".$command);
            }
            if($id===null){
                //何にもヒットしない：おかしい
                throw new \Exception("マークアップされたものが見つかりません。:".$search);
            }
            return "@".$command.$id."@";//ID型のマークアップにして返す
        },
        preg_replace ('/{![^!]+!}/' , "" ,$str ));//{!～～!}は管理画面用の補足なので消してしまう
    }

    static function generateDiscriptionStr(?string $str):String{
        //素のHTMLテキストにマークアップをする。(BRのみ含まれている)
        $commandObjs=self::generateDiscriptionArray($str);
        $txt="";
        foreach ($commandObjs as $commandObj){
            $txt.=$commandObj["txt"];
        }
        return $txt;
    }

    static function generateDiscriptionArray(?string $str): ?array{
        //@[パラメータ][ID]@をaタグもしくは元の記法に変換し、router-link発生箇所を区切りとするオブジェクトを生成する
        if($str==null){return null;}
        $strArray=explode("@",$str);//"@"で分割すればいい。@単体で出てくることはないと信じたい。(バリデーションしててくれ･･････)
        $commandObj=[];
        foreach ($strArray as $s){
            if(!preg_match(self::command_preg_without_a(),$s)){$commandObj[]=["txt"=>nl2br($s)];continue;}
            //マークアップが必要だった場合
            $command = substr ($s , 0,1 );//コマンドを取得
            $id = substr ($s , 1 );//IDを取得
            if(!is_numeric($id)){throw new \Exception("不正なIDを取得しました(数値形式ではありません)");}
            //データベースから名前を検索して置換する
            if($command === "c" ||$command ==="C"){
                //カクテルの場合
                $c=CocktailFactory::getById($id);
                $commandObj[]=[
                    "command"=>"C",//大文字で統一する
                    //"txt"=>"{$c->name}({$c->name_eng})",
                    "txt"=>"{$c->name}",
                    "id"=>$c->id,
                    "is_youtube"=>!empty($c->youtube)
                ];
            }else if($command ==="p" ||$command ==="P"){
                //カテゴリの場合
                $c=CategoryFactory::fromId($id);
                $commandObj[]=[
                    "command"=>"P",//大文字で統一する
                    //"txt"=>"{$c->name}({$c->name_eng})",
                    "txt"=>"{$c->name}",
                    "id"=>$c->id,
                    "is_youtube"=>!empty($c->youtube)
                ];
            }else if($command ==="M" ||$command ==="m"){
                //ミドルカテゴリの場合
                $m=MiddleFactory::getById($id);
                $commandObj[]=[
                    "command"=>"M",//大文字で統一する
                    "txt"=>"{$m->name}",
                    //"txt"=>"{$m->name}({$m->name_eng})",
                    "id"=>$m->id,
                    "is_youtube"=>!empty($m->youtube)
                ];
            }else if($command ==="B" ||$command ==="b"){
                //銘柄の場合
                $b=BrandFactory::getById($id);
                $commandObj[]=[
                    "command"=>"B",//大文字で統一する
                    "txt"=>"{$b->name}",
                    //"txt"=>"{$b->name}({$b->name_eng})",
                    "id"=>$b->id,
                    "is_youtube"=>!empty($b->youtube)
                ];
            }else if($command ==="D" ||$command ==="d"){
                //辞典の場合
                $d=DictionaryFactory::getById($id);
                $commandObj[]=[
                    "command"=>"D",//大文字で統一する
                    "txt"=>"{$d->name}",
                    //"txt"=>"{$d->name}({$d->name_eng})",
                    "id"=>$d->id
                ];
            }else{
                //何にもヒットしない：おかしい
                throw new \Exception("マークアップされたものが見つかりません。:".$id);
            }
        }
        return $commandObj;
    }


    static function at_id_append_note(string $str=null):?string{
        //@[パラメータ][ID]の後にその名前を注釈として付与する(管理画面用)
        if($str==null){return null;}
        return  preg_replace_callback(self::command_preg(),
            function ($matches) {
                $search = substr ($matches[0] , 2 ,-1 );//@とパラメータを除いた文字列を取得
                if(!is_numeric($search)){throw new \Exception("不正なIDを取得しました(数値形式ではありません)");}
                //データベースから名前を検索して置換する
                $command = substr ($matches[0] , 1 ,1 );//先頭の@を除いた1文字
                if($command === "c" ||$command ==="C"){
                    //カクテルの場合
                    $append=Cocktail::where("id",$search)->value("name");
                }else if($command ==="P" ||$command ==="p"){
                    //カテゴリの場合
                    $append= Category::where("id",$search)->value("name");
                }else if($command ==="M" ||$command ==="m"){
                    //ミドルカテゴリの場合は、親カテゴリと一緒に取得しないと紛らわしい
                    $middle= Middle::find($search);
                    $append= $middle->parent_r->name."/".$middle->name;
                }else if($command ==="B" ||$command ==="b"){
                    //銘柄の場合
                    $append= Brand::where("id",$search)->value("name");
                }else if($command ==="D" ||$command ==="d"){
                    //辞典の場合
                    $append= Dictionary::where("id",$search)->value("name");
                }
                if($append===null){
                    //何にもヒットしない：おかしい
                    //throw new \Exception("マークアップされたものが見つかりません。:".$search);
                    return "";//そのまま消してしまえ(考えられるパターンは、削除したページへのリンクが張りっぱなしになってるパターン)
                }
                return $matches[0]."{!".$append."!}";
            },
            $str);
    }

    /*
    static function name_adjustment(string $str):string{
        //表記揺れなどの解決
        //たまに「・」の後に半角スペースが入ってるので消す
        //同時にtrimにより、文末と文頭の空白文字を取り除く
        $str=str_replace('・ ', '・', trim($str));

        return $str;
    }*/


    public static function youtube(string $url_or_token=null):?string{
        //渡された文字列がURLなら、トークンだけ抜き出す
        if(empty($url_or_token)){return null;}
        if(strpos($url_or_token,'http') === false){
            return $url_or_token;//httpが含まれていなければそのまま返す
        }
        //URLなのでトークンだけ抜き出す。とりあえず.comの後、10文字以上続く文字列、と定義しておく。
        if(strpos($url_or_token,'youtu') === false){
            throw new \Exception("youtubeのURLとして正しくありません");
        }
        preg_match('/[a-zA-Z0-9_-]{10,}/', $url_or_token, $matches ,0,strpos($url_or_token,"?v=") );
        return $matches[0];
    }
}
