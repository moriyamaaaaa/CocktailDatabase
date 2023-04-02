<template>
    <div id="detail_container" class="center" v-if="middleDetail">
        <div>
            <div class="title" v-if="this.$store.getters['auth/check']">
                <router-link :class="'title'" :to="{name:'AdminMiddleEdit',params:{id:this.middleDetail.id}}">{{this.middleDetail.name}}({{this.middleDetail.name_eng}})</router-link>
            </div>
            <div class="title" v-else>{{this.middleDetail.name}}({{this.middleDetail.name_eng}})</div>
        </div>
        <bread  v-bind:big_category="kind" :category="category" v-if="kind&&category"></bread>

        <div id="detail_block">
            <div>
                <div id="description_block" class="mt-4 mb-2 mr-2 ml-2">
                    <div v-if="middleDetail" id="description" class="flex1">
                        <description v-bind:description-object="middleDetail.description"></description>
                    </div>
                </div>
                <div id="youtube_section" v-if="middleDetail.youtube">
                    <youtube :url-i-d="middleDetail.youtube"
                             :hour="middleDetail.y_h||0"
                             :minute="middleDetail.y_m||0"
                             :second="middleDetail.y_s||0"
                    ></youtube>
                </div>
            </div>
            <div id="image_container" v-if="middleDetail">
                <imagecomponent
                    v-if="middleDetail.image"
                    :image_file="middleDetail.image"
                    :image_url="middleDetail.image_url"
                    :image_txt="middleDetail.image_txt"
                />
                <div class="amazon_container inimage" v-else>
                    <affiliateContainer
                        :category_id=category.id
                        :middle_id=middleDetail.id
                        :brand_id=(famousBrand)?famousBrand.id:0
                        :is_photo_space=true
                    ></affiliateContainer>
                </div>
            </div>
        </div>
        <div id="famous_container">
            <div v-if="famousBrand && famousBrand.length!=0" id="famous_brand" class="intro_container">
                <div class="block_title"><div class="square_dot famous"></div>有名な銘柄</div>
                <div v-if="famousBrand">
                    <router-link :to="{ name: 'BrandDetail', params: { id: famousBrand.id }}">
                        {{famousBrand.name}}({{famousBrand.name_eng}})
                    </router-link>
                </div>
            </div>
        </div>

        <div id="belong_brand_container" class="in_middle" v-if="brands && brands.length!=0">
            <div class="block_title"><div class="square_dot"></div>登録されている銘柄の一覧</div>
            <brandTable v-if="brands"
                        :brands=brands
            ></brandTable>
        </div>
        <div id="using_cocktail_container" v-if="middleDetail">
            <randomCocktail
                :category="category.id"
                :middle="middleDetail.id"></randomCocktail>
        </div>

        <div class="amazon_container bottom" :class="{is_already_display_inImage:!middleDetail.image}">
            <affiliateContainer
                v-show="middleDetail"
                :category_id=category.id
                :middle_id=middleDetail.id
                :brand_id=(famousBrand)?famousBrand.id:0
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
                    inner: (this.middleDetail)?(this.middleDetail.name + "("+this.middleDetail.name_eng+")"):"",
                }
            }
        },
        data:function(){
            return{
                middleDetail:null,
                category:null,
                kind:null,
                famousBrand:null,
                RandomCocktails:null,
                brands:null
            }
        },
        created() {
            //カテゴリのデータを取ってくる
            const mid=this.$route.params.id
            this.init(mid);
        },
        methods:{
            init(mid){
                console.log("init");
                this.middleDetail=undefined;
                //this.famousBrand=undefined;
                //this.category=undefined;
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/middleDetail', {id:mid})
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //console.log(result)
                        //結果を変数に格納する
                        this.middleDetail=result.middle
                        this.category=result.category
                        this.kind=result.kind
                        this.famousBrand=result.famousBrand
                        this.brands=result.brands
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
            middleDetail(before,after){
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
    }


    div.block_title{
        display: flex;
        align-items: center;
        padding-right:10px;

        &.famous {
            border-color: #006699;
        }
        &.middle{
            border-color: #FF6600;
        }
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
