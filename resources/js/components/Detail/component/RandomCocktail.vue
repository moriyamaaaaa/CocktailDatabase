<template>
    <div>
        <div class="block_title"><div class="square_dot"></div>{{(this.cocktail)?"材料が似たカクテル":(this.baseid)?"同じベースのカクテル":"これを使ったカクテル(ランダム"+this.randomInt+"種)"}}  <div style="display: inline-block;width:10px;"></div>
            <span class="link_span" @click="regetCocktails" @mouseenter="regetHover" @mouseleave="regetDishover" v-bind:class="{regetActive: RegetActive }">
                <font-awesome-icon v-bind:class="{ regetActive: RegetActive }" :icon="['fas', 'redo']" />再取得</span></div>
        <div v-if="RandomCocktails">
            <cocktailTable :cocktails=RandomCocktails
            ></cocktailTable>
        </div>
    </div>
</template>

<script>
    import cocktailTable from "../../Results/Tables/Cocktails"
    import errors from "../../Errors/search"

    export default {
        components: {
            cocktailTable: cocktailTable,
        },
        props:{
            randomInt:{
                type: Number,
                default: 5
            },
            category:null,
            middle:null,
            brand:null,
            cocktail:null,
            baseid:null,
            methodid:null,
            glassid:null
        },
        mixins: [errors],
        created(){
            this.regetCocktails()
        },
        data:function(){
            return{
                RandomCocktails:null,
                RegetActive: false,
            }
        },
        watch: {
            propSet(before,after){
                this.RandomCocktails=null;//ラグで画面に残り続けるのもキモいので
                this.regetCocktails();
            }
        },
        computed:{
            propSet: function() {
                return{
                    category:this.category,
                    middle:this.middle,
                    brand:this.brand,
                    cocktail:this.cocktail,
                    baseid:this.baseid,
                    glassid:this.glassid,
                }
            }
        },
        methods:{
            regetCocktails(){
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getRandomCocktail', {
                    limit:this.randomInt,
                    category:this.category,
                    middle:this.middle,
                    brand:this.brand,
                    cocktail:this.cocktail,
                    base:this.baseid,
                    method:this.methodid,
                    glass:this.glassid
                })
                    .then( (response) =>{
                        var result=response.data.result;//結果を取得する
                        //console.log(result)
                        //結果を変数に格納する
                        this.RandomCocktails=result.RandomCocktails

                    })
                    .catch( (error) =>{
                        //なにかエラーが出た
                        console.log(error);
                        this.searchError(2)
                    })
            },
            regetHover: function() {
                return this.RegetActive = true
            },
            regetDishover: function() {
                return this.RegetActive = false
            }
        }
    }
</script>

<style scoped lang="scss">
    span.link_span{
        color:#337ab7;
        svg path{
            color:#337ab7;
        }
    }

    svg.regetActive path, i.RegetActive,
    span.regetActive{
        text-decoration:underline !important;
        color:#23527c !important;
        cursor: pointer !important;
    }
</style>
