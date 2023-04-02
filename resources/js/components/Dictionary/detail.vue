<template>
    <div id="detail_container" class="center" v-if="dictionary">
        <div>
            <div v-if="dictionary" class="title">{{dictionary.name}}({{dictionary.name_eng}})</div>
        </div>
        <bread :dictionary_category="dictionary.dictionary_category"></bread>
        <div id="description_block" class="mt-4 mb-2 mr-2 ml-2">
            <div v-if="dictionary" id="description" class="flex1">
                <description v-bind:description-object="dictionary.description"></description>
            </div>
        </div>



        <!--製法の場合-->
        <div v-if="is_method">
            <div id="method_cocktail">
                <randomCocktail :methodid=this.dictionary.id
                                :random-int=7></randomCocktail>
            </div>
        </div>


        <!--グラスの場合-->
        <div v-if="is_glass">
            <div id="glass_cocktail">
                <randomCocktail :glassid=this.dictionary.id
                                :random-int=7></randomCocktail>
            </div>
        </div>
    </div>
</template>

<script>
    import bread from "../Detail/component/Breadcrumb"
    import randomCocktail from "../Detail/component/RandomCocktail"
    import description from "../Detail/component/description"
    import errors from "../Errors/search"
    export default {
        components:{
            bread:bread,
            description:description,
            randomCocktail:randomCocktail
        },
        mixin:[errors],

        head: {
            title(){
                return{
                    inner: this.dictionary.name + "("+this.dictionary.name_eng+")",
                }
            }
        },
        data: function () {
            return {
                dictionary: undefined,
            }
        },

        created() {
            //カテゴリのデータを取ってくる
            const id=this.$route.params.id
            this.init(id);
        },
        computed:{
            is_method:function(){
                return this.dictionary.dictionary_category.name=='製法'
            },
            is_glass:function(){
                return this.dictionary.dictionary_category.name=='グラス'
            }
        },
        methods:{
            init(id){
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC + '/api/dictionaryDetail', {id:id})
                    .then((response) => {
                        var result = response.data.result;//結果を取得する
                        //結果を変数に格納する
                        this.dictionary = result.dictionary
                        this.$emit('updateHead')
                    })
                    .catch((error) => {
                        //なにかエラーが出た
                        console.log(error);
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
        }
    }
</script>

<style scoped lang="scss">
    @import "../Detail/detail";
    @import "../mq";

    div.title{
        font-size: 250% !important;
    }


    div#method_cocktail,
    div#glass_cocktail{
        border-left-width: 5px;
        border-left-style: solid;
        padding-left: 7px;
        margin-top: 20px;

        &#method_cocktail{
            border-left-color: #3399FF;
        }
        &#glass_cocktail{
            border-left-color: #1f0d85;
        }


    }
</style>
