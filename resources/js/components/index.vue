<template>
    <div>
        <vue-loading v-if="newMovieCocktail===undefined" type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }"></vue-loading>
        <div class="flexdiv titlebox ">
            <div class="flexdiv">
                <div class="title">
                    <font-awesome-icon :icon="['fas', 'cocktail']" />
                </div>
                <div class="title">
                    宅飲みカクテルデータベース
                </div>
            </div>
            <div class="subtitle">
                ―宅飲み指向データベース。新たな出会いをあなたに。
            </div>
        </div>
        <div id="topPageMainBoxContainer">

            <div v-if="this.newMovieCocktail" id="youtube_block" class="flexdiv-wrap">

                <div id="youtube_inner">
                    <div class="youtube_sizing_box">
                        <iframe width="560" height="315" :src="youtubeURL(newMovieCocktail.youtube)"
                                frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    </div>
                </div>
                <div id="youtube_detail">
                    <div class="title"><span class="txt">新作動画：</span><router-link class="txt" :to="{ name: 'CocktailDetail', params: { id: newMovieCocktail.id }}">{{newMovieCocktail.name}}({{newMovieCocktail.name_eng}})</router-link></div>

                    <div class="text">
                        <div class="base">ベース：<router-link :to="{ name: 'CategoryDetail', params: { id: newMovieCocktail.base.id }}">{{newMovieCocktail.base.name}}({{newMovieCocktail.base.name_eng}})</router-link></div>
                        <description v-bind:description-object="newMovieCocktail.description"></description>
                    </div>

                </div>
                <infomation-menu class="d-none d-lg-flex"></infomation-menu>
            </div>


            <div id="wide_infomation" class="flexdiv">
                <infomation-menu class="d-none d-sm-flex d-lg-none"></infomation-menu>
                <div id="new_updates_container">
                    <div class="new_updates_div">
                        <div class="title">★最近更新されたカクテル</div>
                        <cocktail :cocktails="recentCocktail" v-if="recentCocktail"></cocktail>
                    </div>
                    <div class="new_updates_div">
                        <div class="title">★おすすめカクテル  <span class="link_reget" @click="getRecommendCocktail" @mouseenter="regetRecommendHover" @mouseleave="regetRecommendDishover" v-bind:class="{regetRecommendActive: RegetRecommendActive }">
                <font-awesome-icon v-bind:class="{ regetRecommendActive: RegetRecommendActive }" :icon="['fas', 'redo']" />再取得</span></div>
                        <cocktail :cocktails="recommendCocktail" v-if="recommendCocktail"></cocktail>
                    </div>
                    <div class="new_updates_div">
                        <div class="title">★気まぐれセレクト  <span class="link_reget" @click="getRandomCocktail" @mouseenter="regetRandomHover" @mouseleave="regetRandomDishover" v-bind:class="{regetRandomActive: RegetRandomActive }">
                <font-awesome-icon v-bind:class="{ regetRandomActive: RegetRandomActive }" :icon="['fas', 'redo']" />再取得</span></div>
                        <cocktail :cocktails="randomCocktail" v-if="randomCocktail"></cocktail>
                    </div>
                </div>
            </div>
        </div>
        <infomation-menu class="d-flex d-sm-none"></infomation-menu>
        <div id="cocktailform_anchor" style="height:20px;"></div>
        <cocktail-form></cocktail-form>

    </div>
</template>

<script>
    import description from "./Detail/component/description"
    import common from "./CommonMixins/Common"
    import cocktail from "./Results/Tables/Cocktails"
    import infomation from "./Top/infomationMenu"
    import form from "./Forms/Search/Cocktail/form"
    import { VueLoading } from 'vue-loading-template'

    export default {
        head: {
            title:{
                inner: 'トップページ',
            }
        },
        mixins:[common],
        components: {
            description: description,
            cocktail:cocktail,
            infomationMenu:infomation,
            cocktailForm:form,
            VueLoading
        },
        data(){
            return {
                newMovieCocktail:undefined,
                recentCocktail:undefined,
                recommendCocktail:undefined,
                randomCocktail:undefined,

                RegetRecommendActive: false,
                RegetRandomActive: false,
            }
        },
        created(){
            //トップページ表示に必要なすべての要素を取得
            //最新youtube
            axios.get(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getNewMovie')
                .then( (response) =>{
                    var result=response.data.result;//結果を取得する
                    //結果を変数に格納する
                    this.newMovieCocktail=result.cocktail
                })
                .catch( (error) =>{
                    //なにかエラーが出た
                    console.log(error);
                })
            //最近カクテル
            this.getRecentCocktail()

            //おすすめカクテル
            this.getRecommendCocktail()

            //ランダムカクテル
            this.getRandomCocktail()

        },
        computed:{

        },
        mounted() {
        },
        methods:{
            getRecentCocktail(){
                axios.get(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/CocktailRecent/7')
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //結果を変数に格納する
                        this.recentCocktail=result.cocktail
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error);
                    })
            },
            getRecommendCocktail(){
                axios.get(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/CocktailRecommend/7')
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //結果を変数に格納する
                        this.recommendCocktail=result.cocktail
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error);
                    })
            },
            getRandomCocktail(){
                axios.get(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/CocktailRandom/7')
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //結果を変数に格納する
                        this.randomCocktail=result.cocktail
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error);
                    })
            },
            regetRecommendHover: function() {
                return this.RegetRecommendActive = true
            },
            regetRecommendDishover: function() {
                return this.RegetRecommendActive = false
            },
            regetRandomHover: function() {
                return this.RegetRandomActive = true
            },
            regetRandomDishover: function() {
                return this.RegetRandomActive = false
            }
        }
    }

</script>

<style lang="scss">
    @import "mq.scss";

    div#topPageMainBoxContainer{
        display: flex;

        @include mqm(md) {
            display: block;
        }
    }

    div.titlebox{
        align-items: center;
        padding:10px;

        @include mqm(sm) {
            display: block !important;
            padding-bottom: 0;
            @include mqm(xs){
                text-align:center;
                margin-bottom:5px;
            }
            div.subtitle{
                text-align: right;
            }
        }

        div.title{
            font-size:120% !important;
            @include mq(sm) {
                font-size:250% !important;
            }
        }

        div.subtitle{
            margin-left:10px;
            @include mqm(xs) {
                display:none;
            }
        }
    }

    div#youtube_block{
        margin:auto;
        padding: 3px;

        max-width:1200px;
        justify-content: center;

        div#youtube_inner{
            max-width:560px;
            flex:5;
            min-width:325px;
            margin-top:auto;
            margin-bottom: auto;//youtubeの動画を垂直方向中央に揃える役目
            margin-right:15px;
            padding:15px;

            div.youtube_sizing_box{
                position: relative;
                width: 100%;
                padding-bottom: 56.25%;
            }
            div.youtube_sizing_box iframe{
                position: absolute;
                top: 0;
                right: 0;
                width: 100% !important;
                height: 100% !important;
            }
        }

        div#youtube_detail{
            max-width:650px;
            margin-left:5px;
            flex:5;/*6*/
            padding:10px;
            min-width:325px;/*つまり,#youtube_innerと合わせて650px以下なら折り返すようにさせる*/

            div.title{
                border-left:5px solid #4499FF;
                border-bottom: 2px solid #4499FF;
                padding-left: 5px;

                .txt{
                    font-size:100%;
                }
            }

            div.text{
                margin-top: 1em;
                margin-left: 1em;

                max-height: 270px;
                overflow-y: auto;

                div.base{
                    border-bottom:2px solid #56bbff;
                    margin-bottom:10px;
                }
            }
        }
    }

    #new_updates_container{
        min-width:450px;
        width:450px;
        @include mqm(xs) {
            width:100vw;
            margin:0;
        }

        div.new_updates_div{
            border: 1px solid #000;
            width:90%;
            max-width:720px;

            margin: auto;
            margin-bottom: 5px;
            padding:5px;
            @include mqm(xs) {
                width:100vw;
                margin: 0;
                padding:0;
            }
        }
        div.title{
            margin :3px;
            border: 1px solid #006699;
            padding:3px;
            background-color: #AADDFF;
            color: #0033FF;
            font-size:100% !important;
            line-height:1em !important;
        }
        table{
            width:100%;/*デフォルトを上書きしている*/
        }
    }

    span.link_reget,span.link_reget svg path{
        color:#003399;
    }
    svg.regetRecommendActive path, i.RegetRecommendActive,
    span.regetRecommendActive,
    svg.regetRandomActive path, i.regetRandomActive,
    span.regetRandomActive{
        text-decoration:none !important;
        color:#23527c !important;
        cursor: pointer !important;
    }
</style>
