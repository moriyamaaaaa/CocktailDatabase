/*ユーザー定義ヘルパ関数群*/


export default class Helper {
    static NOTSTRVALIDATION(){
        return new RegExp(/[!！？\?;；<>_＿＜＞\\|\/"'\*\{\}\^\[\]]/);//ブラックリスト方式
    }
    static is_FromnameResultValidation(str) {
        var reg=Helper.NOTSTRVALIDATION()
        var is_val=!reg.test(str)
        return is_val
    }

    static katakanaToHiragana(src) {
        //全角文字を半角文字にシフト
        //16進数の場合
        return this.Big_to_hankaku(src).replace(/[\u30a1-\u30f6]/g, function(match) {
            var chr = match.charCodeAt(0) - 0x60;
            return String.fromCharCode(chr);
        });
    }

    static Big_to_hankaku(str){
        //英数字の全角を半角にする
        return str.replace(/[Ａ-Ｚａ-ｚ０-９]/g, function(s) {
            return String.fromCharCode(s.charCodeAt(0) - 0xFEE0);
        });
    }

    static onlyNumberAndDot(str){
        //すべてを半角数字に変える(小数点は許容)
        //Numberを返さず文字列として返してみることに
        var result=str.replace(/[０-９]/g, function(s) {
            return String.fromCharCode(s.charCodeAt(0) - 65248);
        }).replace(/[^0-9\.]/g, '')
        return  result
    }

    static sweet_degree_str(degree) {
        if (degree === undefined||degree===99||degree===null) return "-"
        if (degree <= -7) return "辛口"
        if (degree <= -4) return "中辛"
        if (degree <= -1) return "辛め"
        if (degree <= 1) return "普通"
        if (degree <= 3) return "甘め"
        if (degree <= -6) return "中甘"
        return "甘口"
    }

    static fixDecimalPoint(number, demimalint){
        //numberを小数点第demimalint桁までfixする
        var num_obj = new Number(number);
        return num_obj.toFixed(demimalint);
    }

    static aiu(obj,key,asc,method){
        //@param
        //objをkeyでソートする。昇順(asc)=boolean。
        //特殊な操作をさせたい場合はoptionとしてmethodに文字列を渡してコマンドとする。(いまのとこ未使用)
        if(!obj){return {}}

        let list = obj.slice();
            list.sort((a, b) => {
                var a_=a[key]
                var b_=b[key]
                switch (method) {
                    default:
                        //「ベース」と「名前」はひらがなとカタカナを統一する(これもバグるため)
                        a_ = Helper.katakanaToHiragana(a_.toString());
                        b_ = Helper.katakanaToHiragana(b_.toString());
                        //それ以外(通常)　英文字は大文字小文字が混在してるとバグるので調整
                        a_ = (a_)?a_.toLowerCase():a_;//nullだとtoLowerCaseが呼び出せないので
                        b_ = (b_)?b_.toLowerCase():b_;
                }
                return (a_ === b_ ? 0 : a_ > b_ ? 1 : -1) * (asc ? 1 : -1);
            });
        return list;
    }

    static narrow(obj,first){
        //firstから始まるもので絞り込む
        if(!first){return obj}
        return obj.filter( v=> {
            return (Helper.katakanaToHiragana(v.name).startsWith(Helper.katakanaToHiragana(first))
                || Helper.katakanaToHiragana(v.name_eng.toLowerCase()).toLowerCase().startsWith(Helper.katakanaToHiragana(first).toLowerCase())
            )
        })
    }

    static append_null_select(array){
        return [{label:"",value:null}].concat(array)
    }
}
