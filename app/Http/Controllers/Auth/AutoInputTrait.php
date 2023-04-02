<?php

namespace App\Http\Controllers\Auth;



use App\Classes\Factory\AutoInputInfo;
use App\Classes\Markup;
use App\Cocktail;
use App\Dictionary;
use App\Method;
use App\RecipeInstance;
use App\Rules\Amount;
use DB;

trait AutoInputTrait
{
    static $url_raw="http://www.siregenuine.com/recipe/";

    private $newCocktail;
    private $autoInputInfo;

    private $head="aa";//頭文字
    private $num=1;//番号

    //カクテル名で変換するもの
    private $trans_cocktailName=[
        "ウオッカ"=>"ウォッカ",
        "ウオーター"=>"ウォーター",
    ];
    //Rimmed withの解決
    private $trans_rimmed=[
        "sugar"=>"砂糖",
        "Sugar"=>"砂糖",
        "salt"=>"食塩",
        "Salt"=>"食塩",
    ];

    //Rimmed withの解決
    private $trans_glass=[
        "ピルスナー"=>"ピルスナーグラス",
    ];

    //製法の解決
    private $trans_method=[
        "シェーク"=>"シェイク",
        "ミキシング"=>"ブレンド"
    ];
    //How to makeの解決
    private $trans_how_to_make=[
        "、、"=>"、",
        "。。"=>"。",
        "シェーク"=>"シェイク",
        "ソーダ"=>"ソーダ水",
        "添える。"=>"添えて完成。",
        "飾る。"=>"飾って完成。",
        "ピールを振りかける。"=>"ピールを振りかけて完成。",
        "全ての材料をシェークしてグラスに注ぐ。"=>"",
        "全ての材料をシェークしてグラスに注ぎ、"=>"",
        "全ての材料をシェークしてグラスに注ぎ"=>"",
        "全ての材料をシェークして"=>"",
        "全ての材料をシェークして氷を入れたグラスに注ぐ。"=>"",
        "全ての材料をミキシンググラスでステアして氷を入れたグラスに注ぐ。"=>"",
        "全ての材料をミキシンググラスでステアしてグラスに注ぐ。"=>"",
        "全ての材料をブレンダ―でミキシングしてグラスに注ぎ"=>"",
        "全ての材料をブレンダ―でミキシングしてグラスに注ぐ。"=>"",
        "全ての材料をグラスに注ぎ、"=>"",
        "全ての材料をグラスに注ぎステアする。"=>"",
        "全ての材料をブレンダ―でミキシングして氷を入れたグラスに注ぐ。"=>"",
        "ミキシンググラスでステアして"=>"",
        "全ての材料を氷を入れたグラスに注ぎステアする。"=>"",
        "クラッシュアイスを入れたグラスに注ぐ。"=>"",
        "クラッシュドアイスを入れたグラスに注ぐ。"=>"",
    ];

    //製法の解決
    private $units=[
        //ついでにamountで問題になりそうなものも変換
        "tsp."=>"tsp",
        "dashes"=>"dash",
        "drops"=>"drop",
        "カップ"=>"cup",
        "枚"=>"個",
        "本"=>"個",
    ];



    private function trans($subject, array $dictionary){//$itemの中に、言い換え可能なものがあれば置き換える
        foreach($dictionary as $key=>$value){$subject=str_replace($key, $value, $subject);}return $subject;
    }
    static function transStatic($subject, array $dictionary){return (new AutoInputController())->trans($subject,$dictionary);}

    private function autoInputInfo():AutoInputInfo{
        return $this->autoInputInfo;
    }
    private function newAutoInputInfo():AutoInputInfo{
        $this->autoInputInfo=new AutoInputInfo;
        return $this->autoInputInfo();
    }
    private function newCocktail():Cocktail{
        return $this->newCocktail;
    }
    private function new_newCocktail():Cocktail{
        $this->newCocktail=new Cocktail();
        $this->newCocktail->note="";//念の為･･････
        return $this->newCocktail();
    }

    private function load_counter(){
        //保存されている情報を取り出す
        $column=DB::table('m_auto_input')->first();
        if(!empty($column->header)){
            $this->head=$column->header;
            $this->num=$column->number;
        }//初期値
    }
    private function save_counter(){
        DB::table('m_auto_input')->update([
            "header"=>$this->head,
            "number"=>$this->num
        ]);
    }

    private function generate_url():string{
        return self::$url_raw."$this->head/".$this->head.sprintf('%04d', $this->num).".htm";
    }

    private function get_glass(string $glass_name): ?int{
        //日本語が渡されてくるので、グラスのIDを返却する。
        //見つからなければエラーにぶっこんでnullでも返しておけば良い。
        $raw_glass_name=$glass_name;

        //クラッシュドアイス入り、氷入り、などを取り除く(めんどいからハードコーディング)
        if(strpos($glass_name,"氷入り")!==FALSE){
            $this->newCocktail->ice=1;$glass_name=str_replace("氷入り","",$glass_name);
        }else if(strpos($glass_name,"クラッシュアイス入り")!==FALSE){
            $this->newCocktail->ice=2;$glass_name=str_replace("クラッシュアイス入り","",$glass_name);
        }else if(strpos($glass_name,"クラッシュドアイス入り")!==FALSE){
            $this->newCocktail->ice=2;$glass_name=str_replace("クラッシュドアイス入り","",$glass_name);
        }
        /*
        if(strpos($glass_name,"カクテルグラス")!==FALSE){
            $this->result->option_commands[]="cocktail_glass";//カクテルグラスの場合のみ、60mlを基準にしたいので
        }*/

        //Rimmed with なんとかのストリップ
        if(preg_match('/[\(（]Rimmed with (.+)[）\)]/u', $glass_name, $matches)){
            $glass_name=preg_replace('/ *[\(（]Rimmed with (.+)[）\)]/u',"",$glass_name);
            //なんかあった
            foreach($this->trans_rimmed as $key=>$value){
                if($matches[1]==$key){$this->autoInputInfo->rimmed_garnish=$value;break;}//rimmed_garnishに該当するものを入れる
            }

            if(empty($this->autoInputInfo->rimmed_garnish)) {
                $this->autoInputInfo()->pushError("{$matches[1]}が判定できません。(Rimmed with)");
            }
        }

        //グラスの名前が抜き出せたので、あとはそれで検索をかけてOK
        $glass_name=$this->trans($glass_name,$this->trans_glass);
        $glass_id=Dictionary::where("name_search",Markup::convert_to_name_search($glass_name))->value("id");
        if(!empty($glass_id)){
            return $glass_id;
        }

        //見つからない。エラー。
        //$this->autoInputInfo()->pushError("グラス「{$raw_glass_name}」が見つかりません。");
        $this->newCocktail()->note.="容器は{$raw_glass_name}を用いる。".PHP_EOL;
        return null;
    }

    private function get_method(string $method_name):?int{
        //日本語が渡されてくるので、製法のIDを返却する。
        $id = Method::where("name",$this->trans($method_name,$this->trans_method))->value("id");
        if(!empty($id)){
            return $id;
        }

        //見つからない。エラー。
        $this->autoInputInfo()->pushError("製法「{$method_name}」が見つかりません。");
        return null;
    }

    //コピペしてきたヘルパ関数。たぶんもっといい書き方ありそうだけど修正がめんどくさいのでこのまま放置。
    static function ex_explode($word_array, $str) :array{
        $return = array();

        //文字列を配列に入れる
        $array = array($str);

        //分割文字ごとにforeach
        foreach ($word_array as $value1){

            //文字列の配列を分割
            foreach ($array as $key => $value2) {
                $return = array_merge($return, explode($value1, $value2));

                //配列の最後になったら初期化
                if(count($array) - 1 === $key) {
                    $array = $return;
                    $return = array();
                }
            }
        }
        return $array;
    }

    private function set_recipies(string $materials):void{
        $recipies= AutoInputTrait::ex_explode(["、","。",". ","． "], $materials);
        //$results=array();
        foreach($recipies as $key=>$recipe){
            //まず、名前と分量に分割する
            if(strpos($recipe, " ")!==false){
                list($name,$amount)=explode(" ",$recipe,2);
            }else{
                //途中に数字がでてきたらそこで分割してみることにした。
                preg_match('/[^1-9]([0-9]+ml|[0-9]+\/[0-9]+|適量|[1-9](dash|tsp|drop)|枚|本|少量)(（振りかける）|（振りかける） |（フロート）|（沈める）|を振りかける)+/u', $recipe, $matches, PREG_OFFSET_CAPTURE);
                if(!isset($matches[0])){
                    $this->autoInputInfo()->pushError("レシピが自動判別不能です。人力で入力して下さい=>{$recipe}");
                    continue;
                }
                $point=$matches[0][1];//マッチするのは最後の文字部分
                $sub= substr($recipe, 0,$point);
                $name=$sub.mb_substr($recipe, mb_strlen($sub),1);
                $amount= mb_substr($recipe, mb_strlen($name));
            }
            $amount=$this->trans($amount,$this->units);//紛らわしい単位を整形する

            $amount=$this->autoInputInfo()->strip_sprinkle_and_switchProp($name,$amount);//「振りかける」等のストリップと設定
            $amount=$this->autoInputInfo()->strip_float_and_switchProp($name,$amount);//（フロート）等のストリップと設定
            $amount=$this->autoInputInfo()->strip_pushCoffee_and_switchProp($amount);//（プースカフェ）等のストリップと設定
            $amount=$this->autoInputInfo()->strip_drop_and_switchProp($name,$amount);//（沈める）

            $one_glass="1glass";
            if(strpos($amount, $one_glass)!==false && $this->newCocktail()->glass==7){//検索するとコストなのでハードコーディング。
                $amount=str_replace($one_glass, '60ml', $amount);//60mlに変換
            }

            //レシピインスタンスを作成し格納する
            $this->autoInputInfo()->setInstance(RecipeInstance::generateRecipeInstance($name,$amount));
        }

        return;
    }

    public function next(bool $is_404=false):bool{
        //テスト用に強制する
        //$this->head="aa";
        //$this->num=17;
        //return true;

        if(!$is_404){$this->num++;return true;}//ページが存在する状態であれば、カウンタを1つ進めるだけで良い。

        //404だった場合、検索文字を1つ進めてカウンタ1に戻す。
        $vowel=collect(["a","k","s","t","n","h","m","y","r","w"]);
        $consonant=collect(["a","i","u","e","o"]);
        $this->num=1;

        $now_key=$consonant->search($this->head[1]);//子音のキーを検索する
        if(++$now_key<$consonant->count()){
            //オーバーフローは起きないのでそのまま返す
            $this->head=$this->head[0].$consonant->get($now_key);
            return true;
        }
        //子音がオーバーフローを起こしたので母音を一つ進める。
        $v_key=$vowel->search($this->head[0]);
        if(++$v_key<$vowel->count()){
            //オーバーフローは起きないのでそのまま返す
            $this->head=$vowel->get($v_key).$consonant->get(0);
            return true;
        }

        //woまで来た。終了。
        return false;
    }
}
