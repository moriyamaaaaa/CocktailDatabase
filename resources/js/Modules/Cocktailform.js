export default {
    namespaced: true,
    state: {
        result:undefined,
    },
    mutations: {
        setResult(state,{result}){
            state.result=result;//結果をstateに格納
        }
    },
    actions: {
        getCocltailList({commit},payload){
            //APIから結果を取得しフィールドに格納する
            console.log(payload.cocktailSearchClass.getObj())
            return axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/cocktailSearch', payload.cocktailSearchClass.getObj())
                .then( (response) =>{
                    var result=response.data.result;//結果を取得する
                    commit('setResult', {
                        result: result
                    })
                })
                .catch(function (error) {
                    //なにかエラーが出た
                    console.log(error);
                    //return Promise.reject(error)
                    return Promise.reject( new Error("エラー"));
                })
        },
    }
}
