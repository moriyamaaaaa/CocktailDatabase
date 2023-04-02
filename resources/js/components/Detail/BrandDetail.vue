<template>
    <div id="detail_container" class="center"v-if="brandDetail">
        <div>
            <div class="title" v-if="this.$store.getters['auth/check']">
                <router-link :class="'title'" :to="{name:'AdminBrandEdit',params:{id:this.brandDetail.id}}">{{this.brandDetail.name}}({{this.brandDetail.name_eng}})</router-link>
            </div>
            <div class="title" v-else>{{this.brandDetail.name}}({{this.brandDetail.name_eng}})</div>
        </div>
        <bread  v-bind:big_category="kind" :category="category" :middle="middle||undefined"  v-if="kind&&category"></bread>


        <div id="brand_data_container">
            <div id="brand_data_title"><div class="square_dot"></div>Data</div>
            <div id="brand_data">
                Strength:<b>{{brandDetail.strength}}</b>%
            </div>
        </div>


        <div id="detail_block">
            <div>
                <div id="description_block" class="mt-4 mb-2 mr-2 ml-2">
                    <div v-if="brandDetail" id="description" class="flex1">
                        <description v-bind:description-object="brandDetail.description"></description>
                    </div>
                </div>
                <div id="youtube_section" v-if="brandDetail.youtube">
                    <youtube :url-i-d="brandDetail.youtube"
                             :hour="brandDetail.y_h||0"
                             :minute="brandDetail.y_m||0"
                             :second="brandDetail.y_s||0"
                    ></youtube>
                </div>
            </div>
            <div id="image_container" v-if="brandDetail">
                <imagecomponent
                    v-if="brandDetail.image"
                    :image_file="brandDetail.image"
                    :image_url="brandDetail.image_url"
                    :image_txt="brandDetail.image_txt"
                />
                <div class="amazon_container inimage" v-else>
                    <affiliateContainer
                        :category_id=category.id
                        :middle_id=(middle)?middle.id:0
                        :brand_id=brandDetail.id
                        :is_photo_space=true
                    ></affiliateContainer>
                </div>
            </div>
        </div>

        <div id="using_cocktail_container" v-if="brandDetail">
            <randomCocktail
                :category="category.id"
                :middle="(middle)?middle.id:undefined"
                :brand="brandDetail.id"
            ></randomCocktail>
        </div>

        <div id="brands_belong_middle_container" class="in_category" v-if="middle && brands_belong_middle && brands_belong_middle.length!=0">
            <div class="block_title"><div class="square_dot"></div>
                {{middle.name}}の銘柄の一覧</div>
            <brandTable v-if="brands_belong_middle"
                        :brands=brands_belong_middle
            ></brandTable>
        </div>
        <div id="brands_belong_category_except_middle_container" class="in_category" v-if="brands_belong_category_except_middle && brands_belong_category_except_middle.length!=0">
            <div class="block_title"><div class="square_dot"></div>{{category.name}}銘柄の一覧</div>
            <brandTable v-if="brands_belong_category_except_middle"
                        :brands=brands_belong_category_except_middle
            ></brandTable>
        </div>

        <div class="amazon_container bottom" :class="{is_already_display_inImage:!brandDetail.image}">
            <affiliateContainer
                :category_id=category.id
                :middle_id=(middle)?middle.id:0
                :brand_id=brandDetail.id
                :is_photo_space=false
            ></affiliateContainer>
        </div>
    </div>
</template>

<script>
    import randomCocktail from "./component/RandomCocktail"
    import brandTable from "../Results/Tables/Brands"
    import description from "./component/description"
    import errors from "../Errors/search"
    import bread from "./component/Breadcrumb"
    import imagecomponent from "./component/image"
    import youtube from "./component/youtube"
    import AffiliateContainer from "./component/AffiliateContainer";

    export default {
        components: {
            randomCocktail: randomCocktail,
            brandTable: brandTable,
            description:description,
            bread:bread,
            imagecomponent:imagecomponent,
            youtube:youtube,
            affiliateContainer:AffiliateContainer
        },
        mixins: [errors],

        head: {
            title(){
                return{
                    inner: (this.brandDetail)?(this.brandDetail.name + "("+this.brandDetail.name_eng+")"):"",
                }
            }
        },
        data:function(){
            return{
                brandDetail:null,
                category:null,
                kind:null,
                RandomCocktails:null,
                middle:null,
                brands_belong_category_except_middle:null,
                brands_belong_middle:null
            }
        },
        created() {
            //カテゴリのデータを取ってくる
            const bid=this.$route.params.id
            this.init(bid);
        },
        methods:{
            init(bid){
                this.brandDetail=undefined;
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/brandDetail', {id:bid})
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //結果を変数に格納する
                        //console.log(result.brandDetail)
                        this.brandDetail=result.brandDetail
                        this.category=result.category
                        this.kind=result.kind
                        this.middle=result.middle
                        this.brands_belong_category_except_middle=result.brands_belong_category_except_middle
                        this.brands_belong_middle=result.brands_belong_middle
                        this.$emit('updateHead')
                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error)
                        this.searchError(1)//thisの参照が変わるため、ラムダ必須
                    })
            },
        },
        watch: {
            '$route' (to, from) {
                // ルートの変更の検知...
                this.init(to.params.id)
            },
            brandDetail(before,after){
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

    div#brand_data_container{
        margin-top:10px;
        display: flex;

        div#brand_data_title{
            display: flex;
            justify-content: center;
            align-items: center;
            border-right:5px solid #006699;
            padding-left:0;
            padding-right:10px;
            margin-left:5px;
            margin-right:5px;

            div.square_dot{
                border-color: #006699;
            }
        }
    }


    div#detail_block{
        display: flex;

        div{
            flex:1;
        }

        @include mqm(sm) {
            flex-direction: column-reverse;
        }

        div#description_block{
            display: flex;
            @include mqm(sm) {
                display: block;
                //width:200px;
                width:100%;
                margin:auto;
            }
            div#description{
                flex:1;
            }

            /*
            div#image_container{
                flex:1;
                max-width: 50%;
                ::v-deep table img{
                    max-width:100%;
                }
                @include mqm(sm) {
                    //width:200px;
                    width:100%;
                    margin:auto;
                }
                @include mq(md){

                }
            }*/
        }
        div#image_container{
            padding:9px;
            min-width:200px;
            max-width:500px;
            margin:auto;
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
        @include mqm(sm) {
            div.amazon_container.inimage{
                display: none;
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

    }

    div#famous_container,
    div#using_cocktail_container,
    div#brands_belong_category_except_middle_container,
    div#brands_belong_middle_container,
    div#belong_brand_container{
        border-left-width: 5px;
        border-left-style: solid;
        padding-left: 7px;
        margin-top: 20px;

        &#using_cocktail_container{
            border-left-color: #3399FF;
        }
        &#belong_brand_container{
            border-left-color: #FF6600;
        }
        &#famous_container{
            border-left-color: #006699;
        }
        &#brands_belong_category_except_middle_container{
            border-left-color: #9400d3;
        }
        &#brands_belong_middle_container{
            border-left-color: #20b2aa;
        }
    }


    div.block_title{
        display: flex;
        align-items: center;
        padding-right:10px;
    }

    div#belong_brand_container ::v-deep table {
        th.middle, td.middle ,td.category, th.category{
            display: none;
        }
    }

    div.amazon_container{
        &.bottom{
            margin-top:15px;
        }
        &.bottom.is_already_display_inImage{
            @include mq(md) {
                display: none;
            }
        }
    }
</style>
