<template>
    <v-layout id="header">
        <v-flex id="siteTitle" @mouseenter="TitleHover" @mouseleave="TitleDishover">
            <router-link :to="{ name: 'index'}" exact><font-awesome-icon v-bind:class="{ titleLinkActive: TitleActive }" :icon="['fas', 'cocktail']" /></router-link>
            <router-link :to="{ name: 'index'}" exact><span class="d-none d-md-flex" v-bind:class="{ titleLinkActive: TitleActive }">宅飲みカクテルデータベース</span></router-link>
        </v-flex>
        <v-flex>
            <v-btn class="searchButton" color="accent" @click.stop="showCocktailSearchModal=true"><font-awesome-icon :icon="['fas', 'search']"/><span class="d-none d-sm-flex">検索</span><span class="d-none d-md-flex">をはじめる</span></v-btn>
        </v-flex>
        <v-flex>
            <from-name-component />
        </v-flex>
        <v-spacer></v-spacer>
        <v-flex v-if="this.$store.getters['auth/check']" class="d-none d-sm-flex" style="width:120px;">
            <router-link :to="{name:'AdminHome'}">>>TOP</router-link>
            <a @click="logout">ログアウト</a>
        </v-flex>
        <v-flex v-else-if="this.randomWalk" class="d-none d-sm-flex" style="width:120px;">
            <router-link v-if="cocktailCount" :to="{name:this.randomWalk.command,params:{id:this.randomWalk.id}}">現在の登録数：{{cocktailCount}}</router-link>
        </v-flex>
        <cocktailSearchModal v-model="showCocktailSearchModal"/>
    </v-layout>
</template>

<script>
    import fromName from '../Forms/Search/FromName/fromName.vue'
    import cocktailModal from './CocktailSearchModal'
    export default {
        components: {
            fromNameComponent: fromName,
            cocktailSearchModal: cocktailModal
        },
        data () {
            return {
                showCocktailSearchModal: false,
                TitleActive: false,
                cocktailCount:undefined,
                logoutURL:process.env.MIX_SENTRY_DSN_PUBLIC+'/auth/logout',
                randomWalk:null
            }
        },
        created(){
            //ランダムウォークをセット
            this.setRandomWalk();

            //カクテル総数を取得
            axios.get(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/CocktailCount')
                .then( (response) =>{
                    var result=response.data.result;//結果を取得する
                    //結果を変数に格納する
                    this.cocktailCount=result.count
                })
                .catch( (error) =>{
                    //なにかエラーが出た
                    console.log(error);
                })
        },
        methods: {
            //タイトルのリンクのActiveクラス切り替え用
            TitleHover: function() {
                return this.TitleActive = true
            },
            TitleDishover: function() {
                return this.TitleActive = false
            },
            logout:function(){
                //ログアウトする
                this.$store.dispatch('auth/logoutUser');//ログアウトする＝ストア削除のアクション
                location.href=this.logoutURL//強制リダイレクト(サーバーの方もログアウトする必要がある)
            },
            setRandomWalk:function(){
                //ランダムウォークのURL取得
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/RandomWalk')
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //結果を変数に格納する
                        this.randomWalk=result
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error);
                    })
            }
        },
        watch: {
            '$route' (to, from) {
                // ルートの変更の検知...
                this.setRandomWalk();
            },
        },
    }
</script>

<style scoped lang="scss">
    div#header{
        z-index:10;
        align-items: center;
        position: fixed;
        width: 100%;
        background-color: #99DDFF;
        height:40px;
        filter: drop-shadow(0px 10px 3px rgba(0,0,0,0.1));
    }

    div#siteTitle{
        display: flex;
        span,svg {
            font-size: 20px;
            color:#f00;
        }

        svg,span{
            color:#337ab7 !important;
        }
    }

    span.titleLinkActive,svg.titleLinkActive path, i.titleLinkActive{
            text-decoration:none !important;
            color:#23527c !important;
            cursor: pointer !important;
    }


    span.titleLinkActive,svg.titleLinkActive path, i.titleLinkActive{
        text-decoration:none !important;
        color:#23527c !important;
        cursor: pointer !important;
    }

    button.searchButton{
        svg path,span{
            color:#fff;
        }
    }
</style>
