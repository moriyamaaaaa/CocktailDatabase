export default {
    namespaced: true,
    state: {
        user: null,
    },
    getters:{
        user: state => state.user,
        check: state => !!(state.user)
    },
    mutations: {
        setUser(state,result){
            //console.log(result.result)
            //Vue.set(state, "user", result.result)
            state.user=result.result;//結果をstateに格納
            //console.log(state.user)
        },
        logoutUser(state){
            state.user=undefined
        }
    },
    actions: {
        async fetchUser ({ commit }) {
            try {
                const { data } = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC_WITH_COCKTAIL+'/getuser')
                commit("setUser", { result: data.user.data })
            } catch (e) {
                console.log(e);
            }
        },
        logoutUser({commit}){
            commit("logoutUser")
        }
    }
}
