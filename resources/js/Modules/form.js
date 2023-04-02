export default {
    namespaced: true,
    state: {
        categories:undefined,
        kinds:undefined,
        methods:undefined,
    },
    mutations: {
        setResult(state,{result}){
            state.categories=result.Categories;//結果をstateに格納
            state.kinds=result.kinds;//結果をstateに格納
            state.methods=result.methods;//結果をstateに格納
        }
    },
    actions: {
        getAndSetCategories({commit},payload) {
            if(this.state.categories!==undefined){return;}//既に値が格納されているので呼び出す必要なし

            //APIからの結果取得と格納を同時に行う
            axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getKindsForForm', {})
                .then(function (response) {
                    commit('setResult', {
                        result: response.data.result
                    })
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
}
