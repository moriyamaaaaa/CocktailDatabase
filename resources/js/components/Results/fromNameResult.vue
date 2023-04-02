<template>
    <div>
        <div>結果</div>
        <Cocktail
            :cocktails=this.results.intelligence
            v-if="this.results.intelligence && this.results.intelligence.length > 0"
            intelligence=true
        ></Cocktail>
        <div v-if="this.results.intelligence && this.results.intelligence.length > 0" style="height:25px;"></div>

        <Cocktail
            :cocktails=this.results.cocktail
            v-if="this.results.cocktail && this.results.cocktail.length > 0"
        ></Cocktail>
        <div style="height:25px;"></div>
        <CategoryMiddle
            :categoryMiddles=this.results.categoryMiddle
            v-if="this.results.categoryMiddle && this.results.categoryMiddle.length > 0"
        ></CategoryMiddle>
        <div style="height:25px;"></div>
        <Brand
            :brands=this.results.brand
            v-if="this.results.brand && this.results.brand.length > 0"
        ></Brand>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import cocktail from "./children/Cocktail"
    import categoryMiddle from "./children/CategoryMiddle"
    import brand from "./children/Brand"

    export default {
        components: {
            Cocktail: cocktail,
            CategoryMiddle: categoryMiddle,
            Brand: brand,
        },

        head: {
            title(){
                return{
                    inner: '検索結果:'+this.searched_word,
                }
            }
        },
        data:function(){
            return {
                is_ex:false,
                results:{
                    cocktail:null,
                    intelligence:null,
                    //category:null,
                    //middle:null,
                    categoryMiddle:null,
                    brand:null,
                },
            }
        },watch: {
            '$route' (to, from) {
                // ルートの変更の検知...
                this.initResults();
            },
            intelligences: function (newintelligences, oldintelligences) {
                if(this.is_ex){
                    //this.results.intelligence=newintelligences;
                    this.initResults();
                }
            }
        },
        created: function () {
            if (this.$route.path.startsWith('/result/FromNameResultEx')){
                console.log("特殊処理")
                this.is_ex=true;
                this.$store.dispatch('search/getFromnameResult',{str:this.$route.params.word})
                console.log("ここ")
            }else{
                console.log("init");
                this.initResults();
            }
        },
        computed: {
            ...mapState("search",{
                count: state => {
                    if(state.fromNameResult===undefined){return undefined}
                    return state.fromNameResult.count
                },
                is_searching:state=>state.is_searching,
                intelligences:state=>(state.fromNameResult)?state.fromNameResult.Intelligence:null,
                cocktails:state=>(state.fromNameResult)?state.fromNameResult.Cocktail:null,
                categories:state=>(state.fromNameResult)?state.fromNameResult.Category:null,
                middles:state=>(state.fromNameResult)?state.fromNameResult.Middle:null,
                brands:state=>(state.fromNameResult)?state.fromNameResult.Brand:null,
                /*
                cocktails:state=>state.fromNameResult.Cocktail||null,
                categories:state=>state.fromNameResult.Category||null,
                middles:state=>state.fromNameResult.Middle||null,
                brands:state=>state.fromNameResult.Brand||null,

                 */
                searched_word:state=>state.search_word
            }),
        },
        methods: {
            initResults:function(){
                this.results.intelligence= this.intelligences.slice();//「読み込み時のみ」ストアの配列をコピーする(でないとリアクティブ変更になってしまう)
                this.results.cocktail= this.cocktails.slice();//「読み込み時のみ」ストアの配列をコピーする(でないとリアクティブ変更になってしまう)
                //this.results.category= this.categories.slice();
                //this.results.middle= this.middles.slice();
                this.results.categoryMiddle=this.categories.slice().concat(this.middles.slice());//マージした配列を渡す
                //console.log(this.categories)
                //console.log(this.middles.slice())
                //console.log(this.results.categoryMiddle)
                this.results.brand= this.brands.slice();

                this.results.cocktail.searched_word= this.searched_word;
                //this.results.category.searched_word= this.searched_word;
                //this.results.middle.searched_word= this.searched_word;
                this.results.categoryMiddle.searched_word= this.searched_word;
                this.results.brand.searched_word= this.searched_word;

                this.is_ex=false;//これで切っとかないといつまでもウォッチャが反応する
            }
        },
    }
</script>
