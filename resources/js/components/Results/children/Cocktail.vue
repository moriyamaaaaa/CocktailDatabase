<template>
    <div>
        <div class="result_text result_cocktail">
            <span v-if="this.intelligence"><span>インテリジェンスサーチ結果</span> {{this.cocktails.length}}件ヒットしました。<span v-if="!!this.cocktails.searched_word">(検索語句：<b>{{this.cocktails.searched_word}}</b>)</span></span>
            <span v-else><span id="txt_result">カクテル検索結果</span> {{this.cocktails.length}}件ヒットしました。<span v-if="!!this.cocktails.searched_word">(検索語句：<b>{{this.cocktails.searched_word}}</b>)</span></span>
            <br>
            列名をクリックするとソートします。
        </div>
        <cocktail-table :cocktails=this.cocktails></cocktail-table>
    </div>
</template>


<script>
    import cocktailTable from "../Tables/Cocktails"

    export default {
        props:["cocktails","intelligence"],
        components: {
            cocktailTable: cocktailTable
        }
    }
</script>
