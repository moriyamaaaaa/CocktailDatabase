import Helper from "./helper"

export default {
    namespaced: true,
    state: {
        is_searching:false,
        search_word:undefined,
        fromNameResult:undefined//初期値は「未定義」とする(未検索状態)
    },
    mutations: {
        setResult(state,{result}){
            state.fromNameResult=result;//結果をstateに格納
        },
        setWord(state,{word}){
            state.search_word=word;//結果をstateに格納
        },
        switchState(state,bool){
            state.is_searching=bool;
        }
    },
    actions: {
        getFromnameResult({commit},payload) {
            var str=payload.str//入力された文字列
            if (!Helper.is_FromnameResultValidation(str)) {
                throw new Error("バリデーションエラー");
            }//不正なデータが入力されている
            commit('setWord', {word: str})//入力された時点で吐き出しておく
            commit('switchState', true);//検索開始
            //API通信をして結果を受け取る。非同期でいいのでactions内でいいかな。
            axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/fromName', {
                word: str
            })
                .then(function (response) {
                    //ミューテーションをコミットする
                    commit('setResult', {
                        result: response.data.result
                    })
                    commit('switchState', false);//検索終了
                    console.log("検索終了！");
                })
                .catch(function (error) {
                    //なにかエラーが出た
                    console.log(error);
                    commit('setResult', {
                        result: null
                    })
                    commit('switchState', false);//検索終了
                })
        },
        resetResult({commit}){
            //初期値に戻す
           commit('setResult', {
                result: undefined
            })
        }
    }
}
