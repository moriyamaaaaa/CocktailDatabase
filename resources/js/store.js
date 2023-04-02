import Vue from 'vue'
import Vuex from 'vuex'
import search from './Modules/search'
import form from './Modules/form'
import cocktailform from './Modules/Cocktailform'
import auth from "./Modules/auth"
import cocktailEdit from "./Modules/cocktailEdit"

Vue.use(Vuex)


export default new Vuex.Store({
    modules: {
        search: search,//カクテルサーチ用
        form: form,//フォーム用
        cocktailform: cocktailform,//カクテル検索フォームの結果用(vue-routerが使えないための対抗策)
        auth:auth,
        cocktailEdit:cocktailEdit
    }
})
