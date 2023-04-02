import Helper from "./helper"

export default {
    namespaced: true,
    state: {
        categories:undefined,
        middles:undefined,
        brands:undefined,
        glasses:undefined,
        ices:undefined,
        methods:undefined,
        cocktails:undefined,
        drafts:undefined,
    },
    mutations: {
        setResult(state,{result}) {
            state.categories = Helper.aiu(result.Categoryies, "name", true);//結果をstateに格納
            state.middles = Helper.aiu(result.Middles, "name", true);//結果をstateに格納
            state.brands = Helper.aiu(result.Brands, "name", true);//結果をstateに格納
            state.glasses = Helper.aiu(result.Glass, "name", true);//結果をstateに格納
            state.ices = Helper.aiu(result.Ice, "name", true);//結果をstateに格納
            state.methods = result.Methods
        },
        setCocktails(state,{result}){
            state.cocktails=Helper.aiu(result,"name",true);//結果をstateに格納
        },
        setDrafts(state,{result}){
            state.drafts=Helper.aiu(result,"name",true);//結果をstateに格納
        },
    },
    actions: {
        async setBrands({commit}, payload) {
            try {
                var {data: {result:result}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC + '/api/getListForRecipe', {})
                commit('setResult', {
                    result: result
                })
            } catch (error) {
                console.log(e)
            }
        },
        async setCocktails({commit}, payload) {
            try {
                var {data:{result:{Cocktails:list}}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getCocktailList')
                commit('setCocktails', {
                    result: list
                })
            } catch (error) {
                console.log(e)
            }
        },
        async setDrafts({commit}, payload) {
            try {
                var {data:{result:{Cocktails:list}}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getCocktailDraftList')
                commit('setDrafts', {
                    result: list
                })
            } catch (error) {
                console.log(e)
            }
        }
    }
}
