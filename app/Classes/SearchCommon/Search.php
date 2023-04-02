<?php

namespace App\Classes\SearchCommon;
use App\DAO\M_category_kindsDAO;
use App\DAO\M_categoryDAOfunction;

class Search{
    static function isNotDraft(&$model){
        return $model->where("is_draft",0);
    }
    static function isDraft(&$model){
        return $model->where("is_draft",1);
    }

    static function convert_to_search_array($str):Array{
        //空白があれば分割する。
        return preg_split("/( |　)/", $str);
    }
    static function convert_to_name_search($str):string{
        //「・」を削除する(半角カナも追加した)
        return mb_convert_kana(str_replace('・', '', str_replace(' ', '', str_replace('.', '', $str))),'rn');
    }
    static function generate_search_array($str):Array{
        //「・」を削除する(半角カナも追加した)
        $array= array_map(
            function($x) {
                return self::convert_to_name_search($x);
            },
            self::convert_to_search_array($str)
        );
        while( ($index = array_search( "", $array, true )) !== false ) {
            unset( $array[$index] ) ;//空配列がやばい
        }
        return $array;
    }

    static function find_Jap_or_Eng(&$model,String $table,Array $words,String $column){
        //$modelから、$wordを$columnから検索
        $model->where(function($query) use($words,$column,$table){
            foreach($words as $str){
                $query->orwhere($table.".".$column,"like","%".$str."%");
            }
        });
        if($column=="name_eng"){
            //英語だった場合、念の為name_searchも検索するか...
            $model->orWhere(function($query) use($words,$table){
                foreach($words as $str){
                    $query->orwhere($table."."."name_search","like","%".$str."%");
                }
            });
        }
    }
    /*
    static function get_kinds_for_form(): Array{
        //フォームの配列用のデータを取得する
        $kinds = M_category_kindsDAO::get_data_for_list();//ID,name,eng取得

        $result=[];
        foreach($kinds as $k){
            $result[$k->kinds_id]=["kind_name"=>$k->kinds_name,"kind_name_eng"=>$k->kinds_name_eng];
        }
        $category_id=0;
        foreach(M_categoryDAOfunction::get_all_genre() as $r){
            if($category_id != $r->category_id){
                //メインカテゴリが次に移ったとき
                $category_id = $r->category_id;
                $result[$r->kind]["category"][$category_id]=[
                    "category_id"=>$r->category_id,
                    "category_name"=>$r->category_name,
                    "category_name_eng"=>$r->category_name_eng,
                    "category_is_major"=>(bool)($r->category_is_major),
                    ];
            }
            if($r->middle_id===null){continue;}//ミドルカテゴリの設定がない場合
            $result[$r->kind]["category"][$category_id]["middle"][]=[
                    "middle_id"=>$r->middle_id,
                    "middle_name"=>$r->middle_name,
                    "middle_name_eng"=>$r->middle_name_eng,
                    "middle_is_major"=>(bool)($r->middle_is_major),
            ];
        }
        return $result;
    }
    */
}
