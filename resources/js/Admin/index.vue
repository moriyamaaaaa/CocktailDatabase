<template>
    <!--管理画面トップページ　未ログインなら表示不可-->
    <div>
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminCategoryNew'}">カテゴリ新規</router-link>
            </div>
            <div>
                <router-link :to="{name:'AdminCategoryList'}">カテゴリ編集</router-link>
            </div>
        </div>
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminMiddleNew'}">ミドルカテゴリ新規</router-link>
            </div>
            <div>
                <router-link :to="{name:'AdminMiddleList'}">ミドルカテゴリ編集</router-link>
            </div>
        </div>
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminBrandNew'}">銘柄新規</router-link>
            </div>
            <div>
                <router-link :to="{name:'AdminBrandList'}">銘柄編集</router-link>
            </div>
        </div>
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminCocktailDraftList'}">ドラフト編集</router-link>
            </div>
        </div>
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminCocktailNew'}">カクテル新規</router-link>
            </div>
            <div>
                <router-link :to="{name:'AdminCocktailList'}">カクテル編集</router-link>
            </div>
        </div>
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminAutoInput'}">オートインプット実行</router-link>
            </div>
        </div>
        <!--
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminDictionaryNew'}">用語集新規</router-link>
            </div>
            <div>
                <router-link :to="{name:'AdminDictionaryList'}">用語集編集</router-link>
            </div>
        </div>
        -->
        <!--
        <div class="parent">
            <div>
                <router-link :to="{name:'AdminParaPhrase'}">パラフレーズ</router-link>
            </div>
        </div>
        -->
        <div class="parent">
            <div>
                <a href="./open" target="_blank">オートインプットの該当ページを開く(エラー対策)</a><br>
            </div>
            <div>
                <router-link :to="{name:'AdminAutoInputNext'}">オートインプットのカウント＋１</router-link>
            </div>

        </div>
    </div>
</template>

<script>
    export default {
        created() {
            //this.$store.dispatch('auth/setUserInfo')
        },
        methods: {
            /*
            logout() {
                this.$auth.logout()
            },

             */
        },
    }
</script>

<style lang="scss" scoped>
div.parent{
    padding:10px;
}
    
</style>
