<template>
    <div>
        <list-component v-bind:items="this.cocktails" link_name="AdminCocktailEdit"></list-component>
    </div>
</template>

<script>
    import ListComponent from "./ListComponent"
    import { mapState } from 'vuex'

    export default {
        data:function(){
            return {
            }
        },
        components: {
            ListComponent
        },
        computed: {
            ...mapState("cocktailEdit", {
                cocktails: state => state.cocktails,
            }),

        },
        async created() {
            //カテゴリリストを取得
            this.$store.dispatch('cocktailEdit/setCocktails');//BrandデータをVuexに登録
        }
    }
</script>
