<template>
    <div v-if="dictionary" id="container">
        <div class="big_category_container" v-for="category in dictionary" v-if="category.columns.length>0">
            <!--大カテゴリ-->
            <div class="category_title_block">
                {{category.name}}({{category.name_eng}})
            </div>
            <div v-for="column in sortedList(category.columns) ">
                <!--用語-->
                <router-link :to="{ name: 'AdminCocktailEdit', params: { id: column.id }}">{{column.name}}({{column.name_eng}})</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import Helper from "../../Modules/helper"
    export default {
        data: function () {
            return {
                dictionary: undefined,
            }
        },

        head: {
            title(){
                return{
                    inner: "用語辞典",
                }
            }
        },
        created() {
            axios.get(process.env.MIX_SENTRY_DSN_PUBLIC + '/api/getDictionaryIndex')
                .then((response) => {
                    var result = response.data.result;//結果を取得する
                    //結果を変数に格納する
                    this.dictionary = result.dictionary
                })
                .catch((error) => {
                    //なにかエラーが出た
                    console.log(error);
                })

        },
        methods:{
            sortedList(columns) {
                let list = columns.slice();
                list.sort((a, b) => {
                        a = Helper.katakanaToHiragana(a.name.toString());
                        b = Helper.katakanaToHiragana(b.name.toString());
                        return (a === b ? 0 : a > b ? 1 : -1);
                    }
                );
                return list;
            }
        }
    }
</script>

<style scoped lang="scss">
    div#container{
        width:90%;
        padding-top:20px;
        margin:auto;
    }

    div.big_category_container{
        margin-bottom:25px;
    }

    div.category_title_block {
        font-size: 150%;
        font-weight: bold;
        border-left: 5px solid #006699;
        border-bottom: 2px solid #006699;
        padding-left: 5px;
    }
</style>
