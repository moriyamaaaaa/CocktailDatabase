<?php
namespace App\Http\Controllers\Auth;
use App\Classes\Exceptions\SkipAutoInputByRecipe;
use App\Classes\Factory\AutoInputInfo;
use App\Classes\Factory\RecipeFactory;
use App\Classes\Markup;
use App\Cocktail;
use App\Http\Controllers\Controller;
use App\Http\Requests\Detail\Edit\EditCocktailValidate;
use App\Http\Resources\Admin\AutoInput\AutoInputDubs;
use App\Http\Resources\Admin\Detail\CocktailResourceForEdit;
use App\Http\Resources\Detail\RecipeResourceForCocktail;
use App\Http\Resources\Admin\Detail\RecipeResourceForEdit;
use App\Recipe;
use App\RecipeInstance;
use Auth;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use App\Http\Controllers\Auth\AutoInputTrait;
use Goutte\Client;


class AutoInputController extends Controller
{
    use AutoInputTrait;

    public function __construct()
    {
        $this->middleware('auth:web');//認証済でない限りこのコントローラーにアクセスさせない
    }

    public function test(){
        $column=DB::table('m_auto_input')->update(["number"=>115]);
        return dd($this->exe());
    }
    private function generate_url():string{
    return self::$url_raw."$this->head/".$this->head.sprintf('%04d', $this->num).".htm";
}
    public function open(){
        $this->load_counter();
        $url=$this->generate_url();
        header("Location: ".$url);
        exit();
    }
    public function nextCall(){
        $this->load_counter();//まずカウンターを読み出す
        $this->next();//強制的に1つ進める
        start2:
        try {
            return["result"=>$this->exein()];
        }catch (SkipAutoInputByRecipe $e){
            $this->next();//強制的に1つ進める
            goto start2;
        }
    }
    private function exein(){
        $return=[];
        DB::transaction(function () use(&$return) {
            $return= $this->main_streem();//APIリソースを返却する
        });
        return $return;
    }

    public function exe(){
        //APIから叩かれるエンドポイント
        $this->load_counter();//まずカウンターを読み出す
        start:
        try {
            return["result"=>$this->exein()];
        }catch (SkipAutoInputByRecipe $e){
            //スキップすべきものがでてきたので、カウントを1つ増やしてやりなおす。
            $this->next();//強制的に1つ進める
            goto start;
        }
    }

    private function main_streem():array{
        //ループ部分。
        while(true){
            $this->new_newCocktail();//Cocktailインスタンス初期化
            $this->newAutoInputInfo();//オートインプット用インスタンスも初期化
            $return = $this->read();//DOM情報が入っている
            $this->save_counter();//読み取りが完了したのでカウンターをセーブする
            $result=[];
            switch($return["status"]){
                case "EOF":
                    //明らかに不良エラーで落ちたわけだが、拾ってもどうしようもないので何もする必要がない
                case "success":
                    //挿入に成功してるので特に何かする必要はない
                    break;
                case "dub":
                    $result["dubs"]=AutoInputDubs::collection($return["dubs"]);//確か未実装
                    //※ここで同一レシピチェックができたらいいなあ(レシピを強引に列挙することでごまかす予定)
                case "error":
                    //どこでエラーが出たのかをビューに伝えている
                    $result["error"]=$this->autoInputInfo()->errorArray();
                    $result["cocktail"]=CocktailResourceForEdit::make($this->newCocktail());
                    $result["recipes"]=RecipeFactory::generateFromAutoInputInfo($this->autoInputInfo(),true);
                    return $result;
            }
        }
    }

    private function get_contents(){
        //インスタンス生成
        $client = new Client();
        while(true){
            //取得とDOM構築
            $request=$client->request('GET',$this->generate_url());

            //もしnot foundであればカウンタを進めてやり直し
            if(count($request->filter('ul.study li div.no_link'))){
                $bool = $this->next(true);
                if($bool===false){
                    //最後まで来てしまった。終われ。
                    return false;
                }
            }else{
                break;//見つかったのならそのまま
            }
        }
        return $request;
    }

    private function read():array{
        //
        $crawler = $this->get_contents();
        if($crawler===false){
            return ["status"=>"EOF"];
        }
        $study=$crawler->filter('ul.study');//必要なとこだけを抜き出す

        //テキスト抽出
        //#xとかは鬱陶しいので消しちゃいたいところ
        $name=$study->filter('li div.link h3')->text();//カクテル名

        $name= str_replace("―", "ー", $name);//くだらんtypoはここで打ち消しておく。

        try{
            list($jap,$eng_with_brackets)= explode(" （",preg_replace('/ #[1-9][0-9]*/', '', $name),2);
        } catch (\Exception $ex) {
            try{
                list($jap,$eng_with_brackets)= explode("（",preg_replace('/ #[1-9][0-9]*/', '', $name),2);
            } catch (\Exception $ex) {
                return [$ex];
                //dd($name);//これでもダメなら素直にエラーで落としてもらう
            }
        }

        //誤植がウザいのでここで処理する。
        $this->newCocktail()->name=$this->trans($jap,$this->trans_cocktailName);
        $this->newCocktail()->name_eng=mb_substr( $eng_with_brackets , 0 , -1 );//たぶん")"を消してる気がする

        //pタグごとに入っているものを見ていく
        $study->filter('p')->each(function($node)
        {
            $this->parse($node);
        });
        if(!empty($this->autoInputInfo()->garnish_txt)) {
            $this->autoInputInfo()->set_garnishes($this->autoInputInfo()->garnish_txt);//退避させておいた「副材料」を処理(最後にしないと、レシピの先頭についてしまう)
        }
        //レシピ
        $recipies=[];
        foreach ((array)($this->autoInputInfo()->recipeInstances) as $recipeInstance){
            //カクテルグラスの場合のみ、amountを弄る
            if($this->newCocktail()->glass==7 && strpos($recipeInstance->amount, "/")!==false){
                list($now_mol,$now_den)= explode("/", $recipeInstance->amount,2);
                if(ctype_digit((string)$now_mol) && ctype_digit((string)$now_den)
                && $now_mol%$now_den==0){
                    //数字/数字の形であれば、60を基準に計算
                    $recipeInstance->amount=60*($now_mol/$now_den)."ml";
                }
            }

        }
        //Rimmed withの材料をレシピに追加する
        if(!empty($this->autoInputInfo()->rimmed_garnish)){
            $this->autoInputInfo()->setInstance(RecipeInstance::set_garnish_profile($this->autoInputInfo()->rimmed_garnish,"少量"));
        }

        //セットの直前に特殊な操作を行う
        if($this->autoInputInfo()->is_push_coffee){
            $this->newCocktail()->method=5;
        }else if($this->autoInputInfo()->is_hot()){
            $this->newCocktail()->method=6;
        }
        //ノートを整形する
        $this->newCocktail()->note.=$this->autoInputInfo()->generateGarnishNote();
        //dd($this->newCocktail());

        //ベースを設定する
        $this->newCocktail()->base=$this->autoInputInfo()->getBaseCategoryId();

        if(!empty($this->autoInputInfo()->errorArray())){
            //エラーがあったら、専用のビューに飛ばす
            return[
                "status"=>"error",
            ];
        }
        //フォームを流用して挿入する
        $request=new EditCocktailValidate();
        //dd(RecipeFactory::generateFromAutoInputInfo($this->autoInputInfo()));
        $request->merge([
            "name" => $this->newCocktail()->name,
            "name_eng" => $this->newCocktail()->name_eng,
            "base" => $this->newCocktail()->base,
            "glass" => $this->newCocktail()->glass?:null,
            "ice" => $this->newCocktail()->ice?:null,
            "method" => $this->newCocktail()->method,
            "note" => $this->newCocktail()->note?:null,
            "description" => $this->newCocktail()->description?:null,
            "rate" => $this->newCocktail()->rate?:null,
            "sweet_degree" => $this->newCocktail()->sweet_degree?:null,
            "is_major" => $this->newCocktail()->is_major?:false,
            "recipes" => RecipeFactory::generateFromAutoInputInfo($this->autoInputInfo()),//レシピインスタンスを生成する,
        ]);

        $cont=new DetailEditController();
        $cont->cocktail($request);//カクテルを保存する

        //カウントを進める
        $this->next();
        return[
            "status"=>"success",
        ];
    }

    private function parse(Crawler $node){
        //中身をパースするもの
        //$columnがstrongタグ内、$textが平文。
        $column=$node->filter("strong")->text();
        try{
            $text=mb_substr(str_replace($node->filter("strong")->text(), '', $node->text()),1);//strong部分を剥がす
        } catch (\Exception $e){
            return;//何もデータがないカラムが存在している。ただの入力ミスなのでカット。
        }

        $text= str_replace("―", "ー", $text);//置換

        //dump($column);
        //dump($text);
        //要素があるときのみ取得処理を行う
        if(strpos($column,"Glass")!==FALSE){
            //グラスが指定されている
            $this->newCocktail()->glass=$this->get_glass($text);
        }elseif(strpos($column,"Method")!==FALSE){
            $this->newCocktail()->method=$this->get_method(explode(" （", $text)[0]);
        }elseif(strpos($column,"How to Make")!==FALSE){
            $this->newCocktail()->note.=$this->trans($text,$this->trans_how_to_make);
        }elseif(strpos($column,"Meaning")!==FALSE){
            $this->newCocktail()->note.="意味は「".$text."」。";//意味はそのままコピーしちゃえ！
        }elseif(strpos($column,"Material")!==FALSE){
            //材料！
            $this->set_recipies($text);//レシピインスタンスを生成する
        }
        elseif(strpos($column,"Garnish")!==FALSE && !empty($text)){
            $this->autoInputInfo()->garnish_txt=$text;//解析用にコピーしておく(最初にやるとレシピの順番が狂う)
            //$this->autoInputInfo()->set_garnishes($text);
        }
        //dump($this->newCocktail());
        //dump($this->autoInputInfo());
    }

    public function addSkipDB(String $str){
        DB::table('skip_db')->insert(["name"=>$str]);
        return redirect("admin/autoinput/exe");
    }
}
