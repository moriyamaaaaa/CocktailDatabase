export default {
    methods:{
        objsDock(refObjs){
            //フォームオブジェクト配列を受け取り、それをドッキングする
            var result={};
            refObjs.forEach(obj=>{
                Object.assign(result,obj.errors.all())
            })
            return result;
        },
        dockValidationMsgs(array){
            var result;

            Object.keys(array).forEach( key=> {
                array[key].forEach( value=> {
                    result=(result)?result=result.concat([value]):[value]
                })
            })

            return result
        },
        validateExe(vObjArray){
            //validatorクラスの配列を受け取り、バリデーション結果を返す

            //まずはキーとそれに紐付いたエラーメッセージ群の配列にしたい
            var array=this.objsDock(vObjArray)

            //つぎにエラーメッセージ配列を展開し、エラーメッセージだけの配列にする
            var vobjMsgs=this.dockValidationMsgs(array)

            if(vobjMsgs){
                var errormsg="入力項目に誤りがあります"
                vobjMsgs.forEach(v=>{
                    errormsg+="\n"+v
                })
                alert(errormsg);
            }
            return vobjMsgs;
        },

        is_validation(vObjArray){
            //validatorクラスの配列を受け取り、バリデーション結果を返す
            return (this.validateExe(vObjArray))?false:true
        }
    }
}
