<template>
    <div id="detail_container" v-if="this.cocktailDetail!==undefined">
        <div>
            <div class="title" v-if="this.$store.getters['auth/check']">
                <router-link :class="'title'" :to="{name:'AdminCocktailEdit',params:{id:this.cocktailDetail.id}}">{{this.cocktailDetail.name}}({{this.cocktailDetail.name_eng}})</router-link>
            </div>
            <div class="title" v-else>{{this.cocktailDetail.name}}({{this.cocktailDetail.name_eng}})</div>
        </div>
        <div id="cocktail_data">
            <div class="d-none d-sm-flex">
                <table>
                    <tr>
                        <th class="base">ベース</th>
                        <th>製法</th>
                        <th>甘さ</th>
                        <th>おすすめ度</th>
                        <th>度数</th>
                    </tr>
                    <tr class="data_detail">
                        <td>
                            <router-link :to="{ name: 'CategoryDetail', params: { id: parseInt(cocktailDetail.base.id) }}">{{cocktailDetail.base.name}}({{cocktailDetail.base.name_eng}})</router-link>
                        </td>
                        <td>
                            <method-icon :method-id="cocktailDetail.method.method_id"/>
                            <router-link :to="{ name: 'DictionaryDetail', params: { id: parseInt(cocktailDetail.method.method_id) }}">{{cocktailDetail.method.method_name}}</router-link></td>
                        <td>{{sweet_degree_str(cocktailDetail.sweet_degree)||"未評価"}}</td>
                        <td v-bind:class="{ 'none_rate': is_NothasRate }">{{"★".repeat(cocktailDetail.rate)||"未評価"}}</td>
                        <td>{{cocktailDetail.strength}}%</td>
                    </tr>
                </table>
            </div>


            <!--スマホ版-->
            <div class="d-flex d-sm-none" style="margin-bottom:10px;">
                <table>
                    <tr>
                        <th class="base" colspan="4">ベース</th>
                    </tr>
                    <tr class="data_detail">
                        <td colspan="4">
                            <router-link :to="{ name: 'CategoryDetail', params: { id: parseInt(cocktailDetail.base.id) }}">{{cocktailDetail.base.name}}({{cocktailDetail.base.name_eng}})</router-link>
                        </td>
                    </tr>
                    <tr>
                        <th>製法</th>
                        <th>甘さ</th>
                        <th>おすすめ度</th>
                        <th>度数</th>
                    </tr>
                    <tr class="data_detail">
                        <td>
                            <method-icon :method-id="cocktailDetail.method.method_id"/>
                            <router-link :to="{ name: 'DictionaryDetail', params: { id: parseInt(cocktailDetail.method.method_id) }}">{{cocktailDetail.method.method_name}}</router-link></td>
                        <td>{{sweet_degree_str(cocktailDetail.sweet_degree)||"未評価"}}</td>
                        <td v-bind:class="{ 'none_rate': is_NothasRate }">{{"★".repeat(cocktailDetail.rate)||"未評価"}}</td>
                        <td>{{cocktailDetail.strength}}%</td>
                    </tr>
                </table>
            </div>


            <table class="glass_table" v-if="cocktailDetail.glass">
            <tr>
                <th class="glass">グラス</th>
            </tr>
            <tr>
                <td class="glass"> <router-link :to="{ name: 'DictionaryDetail', params: { id: parseInt(cocktailDetail.glass.id) }}">{{(cocktailDetail.ice)?cocktailDetail.ice.name:""}}{{cocktailDetail.glass.name}}</router-link></td>
            </tr>
            </table>
        </div>


        <div id="cocktail_block">
            <div>
                <div id="description_block" class="mt-4 mb-2 mr-2 ml-2">
                    <div v-if="cocktailDetail" id="description" class="flex1">
                        <div class="info_border_container d-flex d-md-none">
                            <div class="info_border">
                                <div class="info_border_real"></div>
                            </div>
                            <div class="info_border_content">§Description§</div>
                            <div class="info_border">
                                <div class="info_border_real"></div>
                            </div>
                        </div>
                        <description v-bind:description-object="cocktailDetail.description"></description>
                    </div>
                </div>
                <div id="youtube_section" v-if="cocktailDetail.youtube">
                    <youtube :url-i-d="cocktailDetail.youtube"
                             :hour="cocktailDetail.y_h||0"
                             :minute="cocktailDetail.y_m||0"
                             :second="cocktailDetail.y_s||0"
                        ></youtube>
                </div>

                <div id="cocktail_recipe">
                    <table>
                        <tr>
                            <th>材料</th>
                            <th class="hidden_xs">Material</th>
                            <th>分量</th>
                        </tr>
                        <tr v-for="r in this.recipes" class="data_detail">
                            <td><!--改行するとスペースが入ってしまう･･････-->
                                <div style="display: inline-block"><router-link :to="{ name: 'CategoryDetail', params: { id: parseInt(r.category.id) }}">{{r.category.name}}</router-link></div><div v-if="r.brand" style="display:inline-block;">(<router-link :to="{ name: 'BrandDetail', params: { id: parseInt(r.brand.id) }}">{{r.brand.name}}</router-link>)</div><div v-else-if="r.middle" style="display:inline-block;">/<router-link :to="{ name: 'MiddleDetail', params: { id: parseInt(r.middle.id) }}">{{r.middle.name}}</router-link></div>{{(!!r.is_optional)?"(任意)":""}}
                            </td>
                            <td class="hidden_xs">
                                <div style="display: inline-block"><router-link :to="{ name: 'CategoryDetail', params: { id: parseInt(r.category.id) }}">{{r.category.name_eng}}</router-link></div><div v-if="r.brand" style="display:inline-block;">(<router-link :to="{ name: 'BrandDetail', params: { id: parseInt(r.brand.id) }}">{{r.brand.name_eng}}</router-link>)</div><div v-else-if="r.middle" style="display:inline-block;">/<router-link :to="{ name: 'MiddleDetail', params: { id: parseInt(r.middle.id) }}">{{r.middle.name_eng}}</router-link>
                                </div>
                            </td>
                            <td class="amount">{{r.amount}}</td>
                        </tr>
                    </table>
                    <div id="note" v-if="cocktailDetail.note">
                        <div><font-awesome-icon :icon="['fas', 'pencil-alt']" />Note</div>
                        <div id="note_txt">
                            <description v-bind:description-object="cocktailDetail.note"></description>
                        </div>
                    </div>
                </div>

                <!--同じ名前のカクテル-->

                <div id="same_name_cocktail_container" v-if="this.sameNameCocktails&&this.sameNameCocktails.length>0">
                    <font-awesome-icon class="fa-fw" :icon="['fas', 'lightbulb']" />同じ名前のカクテルがあります！
                    <cocktail-table
                        :cocktails="this.sameNameCocktails"
                    ></cocktail-table>
                </div>

                <div id="using_cocktail_container">
                    <randomCocktail
                        :cocktail="cocktailDetail.id"
                    ></randomCocktail>
                </div>

                <div id="same_base_container">
                    <randomCocktail
                        :baseid="cocktailDetail.base.id"
                    ></randomCocktail>
                </div>

            </div>

            <div id="image_container" v-if="(cocktailDetail.image||cocktailDetail.image_txt)">
                <imageComponent
                    :image_file="cocktailDetail.image||null"
                    :image_txt="cocktailDetail.image_txt||null"
                    :image_url="cocktailDetail.image_url||null"
                />
            </div>
        </div>
        <div v-if="this.recipes" class="recipe_amazon">
            <div class="amazon_title">使われている材料はこちら</div>
            <div>
                <div style="display:flex;flex-wrap:wrap;justify-content: center;">
                    <div v-for="r in this.recipes">
                        <div class="amazon_container">
                            <affiliateContainer
                                :category_id=r.category.id
                                :middle_id=(r.middle)?r.middle.id:0
                                :brand_id=(r.brand)?r.brand.id:0>
                            </affiliateContainer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import randomCocktail from "./component/RandomCocktail"
    import cocktailTable from "../Results/Tables/Cocktails"
    import description from "./component/description"
    import errors from "../Errors/search"
    import Helper from "../../Modules/helper"
    import youtube from "./component/youtube"
    import common from "../CommonMixins/Common"
    import imageComponent from "./component/image"
    import AffiliateContainer from "./component/AffiliateContainer";
    import methodIcon from "./component/methodIcon"

    export default {
        components: {
            randomCocktail: randomCocktail,
            description:description,
            cocktailTable:cocktailTable,
            imageComponent:imageComponent,
            youtube:youtube,
            affiliateContainer:AffiliateContainer,
            methodIcon:methodIcon
        },
        mixins: [errors,common],

        head: {
            title(){
                if(!this.cocktailDetail){return {inner:""}}
                return{
                    inner: this.cocktailDetail.name + "("+this.cocktailDetail.name_eng+")",
                }
            }
        },
        data:function(){
            return{
                sameNameCocktails:null,
                cocktailDetail:null,
                recipes:null
            }
        },
        created() {
            //カテゴリのデータを取ってくる
            const cid=this.$route.params.id
            this.init(cid);
        },
        computed:{
            is_NothasRate:function(){
                return !this.cocktailDetail.rate
            },
        },
        methods:{
            init(cid){
                this.cocktailDetail=undefined//ラグ対策
                this.recipes=undefined//ラグ対策
                this.sameNameCocktails=undefined//ラグ対策
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/cocktailDetail', {id:cid})
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //console.log(result)
                        //結果を変数に格納する
                        this.cocktailDetail=result.cocktailDetail
                        this.recipes=result.recipe
                        this.same_name_cocktails()//カクテルIDの読み込みが終わったので
                        this.$emit('updateHead')
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error)
                        this.searchError(1)//thisの参照が変わるため、ラムダ必須
                    })
            },

            sweet_degree_str(sweet_degree){
                return Helper.sweet_degree_str(sweet_degree);
            },

            same_name_cocktails(){
                if(!this.cocktailDetail){return undefined}
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getSameNameCocktail', {id:this.cocktailDetail.id})
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        console.log(result)
                        //結果を変数に格納する
                        this.sameNameCocktails=result.SameNameCocktails
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error)
                        this.searchError(4)//thisの参照が変わるため、ラムダ必須
                    })
            },

        },
        watch: {
            '$route' (to, from) {
                // ルートの変更の検知...
                this.init(to.params.id)
            },
            cocktailDetail(before,after){
                scrollTo(0, 0);
            }
        },
    }
</script>

<style scoped lang="scss">
    @import "detail";
    @import "../mq.scss";
    div.title{
        font-size: 250% !important;
    }

    div#cocktail_data{
        margin-top:10px;
        border-left: 5px solid #006699;

        table{
            th.base{
                text-align: left;
            }
            td.data_title{
                padding-left:5px;
                font-size:130%;
                font-weight: bold;
            }
            td.none_rate{
                text-align: center;
            }
        }
        table.glass_table{
            th.glass{
                text-align: left;
            }
        }

    }

    #cocktail_data table th,
    #cocktail_recipe table th,
    table.glass_table th{
        padding:0 5px;
    }
    #cocktail_data table tr.data_detail td,
    #cocktail_recipe table tr.data_detail td,
    table.glass_table td.glass{
        padding:0 5px 5px;
    }


    div#cocktail_block{
        display: flex;

        div{
            flex:1;
        }
        div#image_container{
            min-width:200px;
        }


        @include mqm(sm) {
            flex-direction: column-reverse;
        }

        div#image_container{
            img{
                max-width:100%;
                min-width:200px;
                max-height:500px;
            }
            @include mqm(sm) {
                //width:200px;
                width:100%;
                margin:auto;
                ::v-deep img{
                    max-height:250px;
                    min-width: unset;
                }
            }
        }

        div#description{
            margin-bottom:25px;
        }

        div#youtube_section{
            max-width:550px;

            @include mqm(sm) {
                margin:auto;
            }
        }

        #cocktail_recipe{
            margin-top:10px;
            /*margin-left: 10px;*/
            border-left: 5px solid #FF6600;

            th{
                text-align: left;
            }
            td.amount{
                text-align: right;
            }

            div#note{
                margin-left:15px;

                div#note_txt{
                    border-top:1px solid #98d4d6;
                    margin-left:1em;
                }
            }
        }

    }

    div#same_name_cocktail_container,
    div#using_cocktail_container,
    div#same_base_container{
        border-left-width: 5px;
        border-left-style: solid;
        padding-left: 7px;
        margin-top: 20px;

        &#using_cocktail_container{
            border-left-color: #3399FF;
        }
        &#same_base_container{
            border-left-color: #1f0d85;
        }

        &#same_name_cocktail_container{
            border-left-color: #fae125;
        }

    }

    div.amazon_container{
        /*
        width:300px;
        margin:auto;
        height:268px;
        margin:15px;
        */
        width:580px;
    }


    div.recipe_amazon{
        margin-top:20px;
        margin-bottom:20px;

        div.amazon_title{
            font-size: 15px;
            text-align: center;
        }
    }
    @include mqm(xs) {
        th.hidden_xs,
        td.hidden_xs,{
            display: none;
        }
    }


</style>
