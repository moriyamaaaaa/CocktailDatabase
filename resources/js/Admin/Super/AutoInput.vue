<template>
    <div>
        <vue-loading type="bars" color="#d9544e" :size="{ width: '50px', height: '50px' }" v-if="!this.cocktailData"></vue-loading>
        <cocktail-form
            v-if="cocktailData"
            :init-cocktail="cocktailData"
            :init-recipes="recipes"
            :init-dubs="dubs"
            :init-errors="errors"
            @exe_autoinput="reflesh"
        />
    </div>
</template>

<script>
    import CocktailForm from "./Detail/CocktailEdit"
    import { VueLoading } from 'vue-loading-template'
    export default {
        props:{
            next:{
                default:false,
                type:Boolean
            }
        },
        data:function(){
            return {
                dubs:null,
                errors:null,
                recipes:null,
                cocktailData:null
            }
        },
        components: {
            VueLoading,CocktailForm
        },
        created() {
            this.exe(this.next);
        },
        computed:{
        },
        methods:{
            async exe(forcenext=false){
                //カテゴリリストを取得
                if(forcenext){
                    var {data:{result:result}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/autoinput/nextCall')
                    console.log(result);
                }else{
                    var {data:{result:result}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/autoinput/exe')

                }

                //console.log(await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/autoinput/exe'));
                //データ挿入
                var cocktail=result.cocktail
                this.cocktailData={
                    base:cocktail.base,
                    name:cocktail.name,
                    name_eng:cocktail.name_eng,
                    note:cocktail.note,
                    method:cocktail.method,
                    glass:cocktail.glass,
                    ice:cocktail.ice,
                }
                this.dubs=result.dubs||undefined
                this.errors=result.error
                this.recipes=result.recipes
            },
            async reflesh(){
                console.log("reflesh!");
                this.cocktailData=undefined
                this.dubs=undefined
                this.errors=undefined
                this.recipes=undefined
                scrollTo(0, 0);
                await this.exe(true);
            }
        }
    }
</script>

<style lang="scss" scoped>
    div.my_error{
        max-width:800px;
        color:red;
        margin:auto;
    }
</style>
