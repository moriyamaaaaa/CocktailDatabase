<template>
    <div>
        <div>結果</div>
        <Cocktail
            :cocktails=this.Cocktail
        ></Cocktail>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import cocktail from "./children/Cocktail"
    export default {

        head: {
            title(){
                return{
                    inner: 'カクテル検索結果',
                }
            }
        },
        components: {
            Cocktail: cocktail,
        },
        mounted(){
            if(this.Cocktail===undefined){
                this.$router.push({name: 'home'});//更新ボタンが押されたor不正なアクセス　トップページに移動
            }
        },
        computed: {
            ...mapState("cocktailform",{
                Cocktail:state=>state.result.Cocktail,
            }),
        },
    }
</script>
