<template>
    <div>
        <div class="result_text result_cocktail">
            <span id="txt_result">銘柄検索結果</span> {{this.brands.length}}件ヒットしました。<span v-if="this.brands.searched_word">(検索語句：<b>{{this.brands.searched_word}}</b>)</span>
        </div>
        <brand-table :brands=brands></brand-table>
    </div>
</template>


<script>
    import brandTable from "../Tables/Brands"
    export default {
        props:["brands"],
        components:{brandTable:brandTable}
    }
</script>
