<!--<template>
    <div>
        <headerComponent />
        <router-view />
    </div>
</template>-->

<template>
        <v-app>
            <header-component></header-component>
            <v-content>
                <v-container fluid>
                    <div style="height:45px;"></div><!--ヘッダーのマージン調整用-->
                    <router-view />
                </v-container>
            </v-content>
            <v-footer>
                <div class="flexdiv" style="width:100%;">
                    <div style="flex:1">
                        宅飲みカクテルデータベース ©<a href="https://trc-vlackhistory.net/" target="_blank">ろんぐ</a> <a href="https://twitter.com/virtualDollym" target="_blank"><font-awesome-icon :icon="['fab', 'twitter']" class="twitter_link" /></a>
                    </div>
                    <div>
                        <router-link :to="{ name: 'helpme'}">更新ボランティア募集中...</router-link>
                    </div>
                </div>
                <!--フッター内容-->
            </v-footer>
        </v-app>
</template>

<script>
    import header from './Header/header.vue'
    export default {
        components: {
            headerComponent: header,
        },

        methods: {
        },
    }

</script>

<style lang="scss">
    *{box-sizing: border-box;}/*なぜかグローバルが効いてない･･････*/
    a svg.twitter_link path{
        color:#00acee
    }
</style>
