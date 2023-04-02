<template>
    <div id="parent" v-if="this.is_exist_affiliate" v-bind:class="{ is_photo_space: is_photo_space}">
        <div class="amazon-item-box no-icon">
            <figure class="amazon-item-thumb">
                <a v-if="this.img_url" :href="this.img_href" class="amazon-item-thumb-link" target="_blank" rel="nofollow">
                    <img :src="this.img_url" class="amazon-item-thumb-image">
                </a>
            </figure>
            <div class="amazon-item-content">
                <div class="amazon-item-title">
                    <a v-if="this.title" :href="this.title_href" class="amazon-item-title-link" target="_blank" rel="nofollow">{{this.title}}</a>
                    </div>
                <div class="amazon-item-snippet">
                    <div class="amazon-item-maker" v-if="this.display_command">
                        <span class="price">¥{{this.price}}</span><span class="updated_at"> ({{this.affiliate.updated_at}}取得)</span>
                    </div>
                </div>
                <div class="amazon-item-buttons">
                    <div class="shoplink amazon" v-if="this.amazon_serach">
                        <a :href="this.amazon_serach" target="_blank" rel="nofollow">Amazonで探す<br><span class="button_price amazon_price" :class="{lower:is_amazon_lower_price}">(¥{{this.affiliate.price}})</span></a>
                    </div>
                    <div class="shoplink rakuten" v-if="this.rakuten_serach">
                        <a :href="this.rakuten_serach" target="_blank" rel="nofollow">楽天で探す<br><span class="button_price rakuten_price" :class="{lower:is_rakuten_lower_price}">(¥{{this.affiliate.rakuten_price}})</span></a>
                    </div>
                </div>
                <div class="search_by_item" v-if="this.category_id">
                    <a v-on:click="search_by_category_id">⇒このアイテムが使われているカクテルを探す</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import cocktailSearchClass from "../../../Modules/cocktailSearchClass_instant"
const AMAZON=1;
const RAKUTEN=2;
const HUMAN=99;
    export default {
        props:{
            category_id:Number,
            middle_id:Number,
            brand_id:Number,
            is_photo_space: {
                type: Boolean,
                default: false
            },
        },
        data: function () {
            return {
                affiliate: undefined,
            }
        },
        mounted:function(){
            //フォームの初期値を設定する

            this.$store.subscribe((mutation, state) => {
                if (mutation.type === 'cocktailform/setResult') {
                    //結果が取得できたらこれが発火する。
                    //もし結果表示画面でない場合、結果表示画面に飛ばす。
                    console.log("routename is :"+this.$route.name)
                    if(this.$route.name !== 'SearchCocktailResult') {
                        this.$router.push({name: 'SearchCocktailResult'});//結果表示画面に飛ばす
                    }
                    this.$emit('closeForm');//親コンポーネントにダイアログを閉じさせる
                }
            })
        },
        created() {
            axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getAffiliateData', {
                category_id:this.category_id,
                middle_id:this.middle_id,
                brand_id:this.brand_id??0
            })
                .then( (response) =>{
                    var result=response.data.result;//結果を取得する
                    //console.log(result)
                    //結果を変数に格納する
                    this.affiliate=result;
                })
                .catch( (error) =>{
                    //なにかエラーが出た
                    console.log(error)
                })
        },
        computed:{
            is_exist_affiliate:function (){
                if(!this.affiliate){return false}
                //affiliateが存在していても、内容がなければfalse
                if(!this.affiliate.amazon_detail_url
                && !this.affiliate.rakuten_detail_url
                && !this.affiliate.human_amazon_detail_url) {
                    return false
                }
                return true
            },
            img_url:function(){
                switch(this.display_command){
                    case HUMAN:
                        return this.affiliate.human_image_url;
                    case AMAZON:
                        return this.affiliate.img_medium_url;
                    case RAKUTEN:
                        return this.affiliate.rakuten_image_url;
                }
                return null;
            },

            img_href:function(){
                switch(this.display_command){
                    case HUMAN:
                        if(this.affiliate.human_amazon_detail_url){
                            return this.affiliate.human_amazon_detail_url;
                        }
                        return this.affiliate.amazon_detail_url;
                    case AMAZON:
                        return this.affiliate.amazon_detail_url;
                    case RAKUTEN:
                        return this.affiliate.rakuten_image_url;
                }
                return null;
            },

            title:function(){
                switch(this.display_command){
                    case HUMAN:
                        return this.affiliate.human_title;
                    case AMAZON:
                        return this.affiliate.title;
                    case RAKUTEN:
                        return this.affiliate.rakuten_title;
                }
                return null;
            },

            title_href:function(){
                switch(this.display_command){
                    case HUMAN:
                        return this.affiliate.human_amazon_detail_url;
                    case AMAZON:
                        return this.affiliate.amazon_detail_url;
                    case RAKUTEN:
                        return this.affiliate.rakuten_detail_url;
                }
                return null;
            },

            price:function(){
                switch(this.display_command){
                    case HUMAN:
                        return this.affiliate.human_price;
                    case AMAZON:
                        return this.affiliate.price;
                    case RAKUTEN:
                        return this.affiliate.rakuten_price;
                }
                return null;
            },

            is_amazon_lower_price:function(){
                if(!!this.affiliate.rakuten_price && this.affiliate.price>=this.affiliate.rakuten_price){
                    //楽天の価格が設定されており、かつAmazonのほうが価格が高い場合
                    return false;
                }else{
                    if(!this.affiliate.price){return false;}//そもそもAmazon自体価格設定できていない場合
                    return true;
                }
            },
            is_rakuten_lower_price:function(){
                if(!!this.affiliate.price && this.affiliate.rakuten_price>this.affiliate.price){
                    //Amazonの価格が設定されており、かつ楽天のほうが価格が高い場合
                    return false;
                }else{
                    if(!this.affiliate.rakuten_price){return false;}
                    return true;
                }
            },

            amazon_serach:function(){
                if (this.affiliate.amazon_search_url){
                    return this.affiliate.amazon_search_url;
                }
                return null;
            },
            rakuten_serach:function(){
                if (this.affiliate.rakuten_search_url){
                    return this.affiliate.rakuten_search_url;
                }
                return null;
            },
            display_command:function (){
                //どのデータを表示するか決める
                if (this.affiliate.human_price){
                    return HUMAN;
                }
                if (this.affiliate.price){
                    /*
                    if(!!this.affiliate.rakuten_price && this.affiliate.price>=this.affiliate.rakuten_price){
                        return RAKUTEN;
                    }*/
                    return AMAZON;
                }
                if (this.affiliate.rakuten_price){
                    return RAKUTEN;
                }
                return null;
            },
        },
        methods:{
            search_by_category_id:async function(){
                //カテゴリIDからカクテル一覧を検索する
                cocktailSearchClass.setCategories([this.category_id])
                cocktailSearchClass.setMiddles([999999])//特殊コマンド
                cocktailSearchClass.setMethods([1,2,3,4,5,6])
                await this.$store.dispatch('cocktailform/getCocltailList',{cocktailSearchClass:cocktailSearchClass}).catch(() => {
                    // サーバーエラーが発生した
                    this.searchError(3)
                });
            }
        }

    }
</script>

<style scoped lang="scss">
    .amazon-item-box {
        padding: 22px 25px;
        width: 94%;
        margin: 0 auto 1.6em;
        border: 3px solid #dfdfdf;
        box-sizing: border-box;
        text-align: center;
        position: relative;
    }

    .amazon-item-box {
        position: relative;
    }

    .amazon-item-error.cf {
        display: block;
        line-height: 1.2;
    }

    .amazon-item-thumb {
        width: 160px;
        min-width: 160px;
        margin: 0 auto 5px;
        float: none !important;
    }

    .amazon-item-thumb * {
        display: block;
    }

    .amazon-item-thumb > a > img {
        margin: 0 auto;
        max-width:160px;
    }

    .amazon-item-content {
        line-height: 125%;
        width: 100%;
    }

    .amazon-item-snippet {
        font-size: 0.8em;
        margin-top: 6px;
    }

    .amazon-item-buttons a {
        width: 90%;
        display: block;
        margin: 0px auto 8px;
        padding: 10px 1px;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
        text-align: center;
        color: #fff;
    }

    .amazon-item-buttons a:hover {
        opacity: 0.6;
    }

    .amazon-item-buttons {
        margin-top: 1em;
    }

    .is_photo_space{
        .amazon-item-box {
            text-align: left;
            display: flex;
            flex-direction : column;
            font-size: inherit !important;
        }

        .amazon-item-thumb {
            vertical-align: top;
            box-sizing: border-box;
            max-width:100%;
        }

        .amazon-item-content {
            line-height: 125%;
            vertical-align: top;
            box-sizing: border-box;
            padding-left: 25px;
            width: 100%;
        }

        .amazon-item-buttons {
            display: flex;
            flex-direction : column;
        }

        .amazon-item-buttons a {
            width: auto;
            text-align: center;
            margin: 0;
            border-radius: 3px;
        }

        .amazon-item-buttons a img {
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .amazon-item-buttons > * {
            width: 100%;
            margin: 2px;
            box-sizing: border-box;
        }
    }

    @media screen and (min-width: 768px){
        .amazon-item-box {
            text-align: left;
            display: flex;
            font-size: inherit !important;
        }

        .amazon-item-thumb {
            vertical-align: top;
            box-sizing: border-box;
            min-width: auto !important;
        }

        .amazon-item-content {
            line-height: 125%;
            vertical-align: top;
            box-sizing: border-box;
            padding-left: 25px;
            width: 100%;
        }

        .amazon-item-buttons {
            display: flex;
            flex-wrap: wrap;
        }

        .amazon-item-buttons a {
            width: auto;
            text-align: center;
            margin: 0;
            border-radius: 3px;
        }

        .amazon-item-buttons a img {
            position: absolute;
            bottom: 0;
            right: 0;
        }

        .amazon-item-buttons > * {
            /*ここ要修正*/
            width: 40%;
            margin: 2px;
            box-sizing: border-box;
        }
    }
    .shoplink{
        display: flex;
        flex-direction: column;

        & a{
           color:#FFF !important;
        }
        &.amazon a {
            background: #f79901;
        }

        &.rakuten a {
            background: #bf0000;
        }

        .button_price{
            color:#fff;
            font-size:1.3em;

            &.lower{
               &.rakuten_price{
                   color:#ff0;
               }
            }
        }
    }

    span.price{
        color:#f00;
        font-size:1.5em;
    }
</style>

