<template>
    <div style="display: flex;width:300px;">
        <form method="post" v-on:submit.prevent="onSubmit">
            <input class="text_search_input" type="text" name="txt" v-model="inputted"　placeholder="名前から検索"
                   v-bind:class="{ active: isActive, 'text-danger': hasError }">
        </form>

        <!--リンクがクリック可-->
        <router-link v-if="is_cango" :to="{name:'FromNameResult',params:{word:inputted}}" class="btn btn-sm btn-info" v-bind:class="{'text-danger': hasError }">
            <v-btn class="fromNameButton sucess" color="blue lighten-2" small>
                <font-awesome-icon :icon="['fas', 'search']"/><span class="message d-none d-sm-flex">{{this.count}}件ヒット</span><span class="message d-flex d-sm-none">{{this.count}}</span>
            </v-btn>
        </router-link>

        <!--エラーが出た時-->
        <v-btn class="fromNameButton" v-else-if="this.hasError" color="red darken-1" small @click="inputted=''">
            <font-awesome-icon :icon="['fas', 'search']"/><span class="message d-none d-sm-flex">{{message}}</span>
        </v-btn>

        <!--その他：初期状態-->
        <v-btn v-else class="fromNameButton init" color="grey lighten-2" small disabled>
            <div class="d-none d-sm-flex">
                <font-awesome-icon :icon="['fas', 'search']"/><span class="message">{{message}}</span>
            </div>
            <div class="d-flex d-sm-none">
                <span class="message">-</span>
            </div>
        </v-btn>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    //import { mapActions } from 'vuex'
    import Helper from "../../../../Modules/helper"
export default {
    name: "fromName",
    data: function () {
        return {
            isActive: true,
            hasError: false,
            inputted:this.searched_word
        }
    },
    watch: {
        inputted: function (newData, oldData) {
            //console.log(this.fromNameResult)
            if (newData==="") {
                //フォームが空になったとき
                this.hasError=false;
                this.$store.dispatch('search/resetResult');//初期化する
                return false;
            }
            //バリデーション
            if (!Helper.is_FromnameResultValidation(newData)) {
                //バリデーションエラー
                //console.log("バリデーションに引っかかった")
                this.hasError=true;//エラークラスを起動
                return false;//バリデーションエラーなので終了
            }
            //console.log("バリデーション通過")
            this.hasError=false;//エラークラスを削除

            var result=this.debouncedGetResult({str:newData});//500ms後に実行
            return//処理はこれでいい　次はストアの変更をwatchする。
        }
    },
    created:function() {
        this.debouncedGetResult = _.debounce(this.getResult, 500)
    },
    methods:{
        getResult:function({str:newData}){
            //APIから結果を受け取るメソッド
            this.$store.dispatch('search/getFromnameResult',{str:newData})
        }
    },
    computed: {
        ...mapState("search",{
            count: state => {
                if(state.fromNameResult===undefined){return undefined}
                return state.fromNameResult.count
            },
            is_searching:state=>state.is_searching,
            fromNameResult:state=>state.fromNameResult,
            searched_word:state=>state.search_word
        }),
        message:function () {
            if(this.hasError){return "Error"}
            if(this.is_searching){return "検索中..."}
            if(this.fromNameResult===undefined){return "入力して下さい"}//初期値
            if(this.fromNameResult===null){this.hasError=true; return "サーバーエラー"}//500エラー
            if(this.count===0){/*this.hasError=true;*/ return "0件ヒット"}
            return this.count+"件ヒット";
        },
        is_cango:function(){
            return !(!this.count || this.hasError || this.is_searching)
        }
    },
    beforeRouteUpdate (to, from, next) {
        //再描画前のアクション
        //console.log("ssss")
        next();
        //console.log("aaaaaa")
        //再描画後のアクション
    }

}
</script>

<style scoped lang="scss">
    @import "../../../mq.scss";

input.text_search_input{
    background-color: #eee;
    border:3px double #337ab7;
    border-radius: 10px;
}

button.fromNameButton{
    @include mq(sm) {
        width:150px;
    }

    svg path,span{
        color:#fff;
    }
    span.message{
        .sucess &{
            color:#FFF;
        }
        .hasError &{
            color:#F00;
        }
        .init &{
            color:#FFF;
        }
    }
}

    a.btn{
        text-decoration: none !important;
    }
</style>
