import index from './components/index.vue';
import mainView from './components/mainView.vue'
import FromNameResult from './components/Results/fromNameResult.vue'
import SearchCocktailResult from './components/Results/ResultListCocktail'
import CategoryDetail from './components/Detail/CategoryDetail'
import CocktailDetail from './components/Detail/CocktailDetail'
import MiddleDetail from './components/Detail/MiddleDetail'
import BrandDetail from './components/Detail/BrandDetail'
import dictionary from './components/Dictionary/index';
import dictionaryDetail from './components/Dictionary/detail';
import adminParent from "./Admin/parent"
import helpme from "./components/helpme"

import store from './store';

function admin (path) {
    return () => import(`./Admin/${path}.vue`).then(m => m.default || m)
}

function adminSuper (path) {
    return () => import(`./Admin/Super/${path}.vue`).then(m => m.default || m)
}

export default function () {
    return  [
        {
            path: '/',      // このパスにアクセスしたら
            name: 'home',
            component: mainView, // このコンポーネントを呼ぶ
            children: [
                //メインビュー内で描写されるもの
                {path: '', name: 'index', component: index},
                {path: 'index', component: index},
                {path: 'helpme',name: 'helpme', component: helpme},

                {path: 'result/FromNameResult/:word', name: "FromNameResult", component: FromNameResult},
                {path: 'result/FromNameResultEx/:word', name: "FromNameResult", component: FromNameResult},
                {
                    path: 'result/Cocktails',
                    name: 'SearchCocktailResult',
                    component: SearchCocktailResult,
                    props: (route) => ({
                        ...route.params
                    })
                },

                //各論
                {path: 'detail/category/:id(\\d+)', name: "CategoryDetail", component: CategoryDetail},
                {path: 'detail/middle/:id(\\d+)', name: "MiddleDetail", component: MiddleDetail},
                {path: 'detail/brand/:id(\\d+)', name: "BrandDetail", component: BrandDetail},
                {path: 'detail/cocktail/:id(\\d+)', name: "CocktailDetail", component: CocktailDetail},

                //用語辞典
                {path: 'dictionary/', name: "DictionaryIndex", component: dictionary},
                {path: 'dictionary/:id', name: "DictionaryDetail", component: dictionaryDetail},


                //Administrator
                {
                    path: 'admin',      // このパスにアクセスしたら
                    component: admin('parent'), // このコンポーネントを呼ぶ
                    children: [
                        {path: '', name: 'AdminHome', component: admin('index')},
                        {path: 'list/Category', name: 'AdminCategoryList', component: adminSuper('CategoryList')},
                        {path: 'list/Middle', name: 'AdminMiddleList', component: adminSuper('MiddleList')},
                        {path: 'list/Brand', name: 'AdminBrandList', component: adminSuper('BrandList')},
                        {path: 'list/Dictionary', name: 'AdminDictionaryList', component: adminSuper('DictionaryList')},
                        {path: 'list/Cocktail', name: 'AdminCocktailList', component: adminSuper('CocktailList')},
                        {path: 'list/CocktailDraft', name: 'AdminCocktailDraftList', component: adminSuper('CocktailDraftList')},

                        {path: 'edit/Category/:id(\\d+)', name: 'AdminCategoryEdit', component: adminSuper('Detail/CategoryEdit'),
                            props: route => ({ category_id: Number(route.params.id) }) },
                        {path: 'edit/Category/', name: 'AdminCategoryNew', component: adminSuper('Detail/CategoryEdit')},
                        {path: 'edit/Middle/:id(\\d+)', name: 'AdminMiddleEdit', component: adminSuper('Detail/MiddleEdit'),
                            props: route => ({ middle_id: Number(route.params.id) }) },
                        {path: 'edit/Middle/', name: 'AdminMiddleNew', component: adminSuper('Detail/MiddleEdit')},
                        {path: 'edit/Brand/:id(\\d+)', name: 'AdminBrandEdit', component: adminSuper('Detail/BrandEdit'),
                            props: route => ({ brand_id: Number(route.params.id) }) },
                        {path: 'edit/Brand/', name: 'AdminBrandNew', component: adminSuper('Detail/BrandEdit')},
                        {path: 'edit/Dictionary/:id(\\d+)', name: 'AdminDictionaryEdit', component: adminSuper('Detail/DictionaryEdit'),
                            props: route => ({ dictionary_id: Number(route.params.id) }) },
                        {path: 'edit/Dictionary/', name: 'AdminDictionaryNew', component: adminSuper('Detail/DictionaryEdit')},
                        {path: 'edit/Cocktail/:id(\\d+)', name: 'AdminCocktailEdit', component: adminSuper('Detail/CocktailEdit'),
                            props: route => ({ cocktail_id: Number(route.params.id) }) },
                        {path: 'edit/Cocktail/', name: 'AdminCocktailNew', component: adminSuper('Detail/CocktailEdit')},

                        //オートインプット関連
                        {path: 'autoinput/exe', name: 'AdminAutoInput', component: adminSuper('AutoInput')},
                        {path: 'autoinput/next', name: 'AdminAutoInputNext', component: adminSuper('AutoInput'),
                            props: route => ({ next: true })},
                        {path: 'autoinput/paraphrase', name: 'AdminParaPhrase', component: adminSuper('ParaPhraseList')},
                    ],
                    beforeEnter: async (to, from, next) => {
                        //このルートは管理画面以外進入不可
                        //Vuexを見て、ユーザー情報が入っていればOK
                        if(!store.getters["auth/check"]){
                            //入っていなければAPIから取得する
                            await store.dispatch('auth/fetchUser')
                            //console.log(store.getters["auth/user"])
                            if(!store.getters["auth/check"]){
                                //APIがログインしていないと判定したので、リジェクト
                                next({name: 'Login'})
                                return
                            }
                        }
                        //ユーザー情報が入っている。
                        next();
                    }
                },
                //未認証でも侵入可能なAdminルート
                {
                    path: 'admin',      // このパスにアクセスしたら
                    component: adminParent, // このコンポーネントを呼ぶ
                    children: [
                        {path: 'login', name: 'Login', component: adminSuper('login')},
                    ],
                },

                //404
                {path: '*', component: index},
            ],
        },

        {
            path: '/auth/:provider/callback',
            component: {
                template: '<div class="auth-component"></div>'
            }
        },
    ]
};

