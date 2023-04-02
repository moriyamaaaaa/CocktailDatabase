<template>
    <div id="parent"><v-btn id="closeBtn" v-if="is_modal" color="green darken-1" text @click.stop="$emit('closeForm',$event)" v-bind:style="{ display: closedisplay}">Close</v-btn>
        <v-form method="post" v-on:submit.prevent="onSubmit">
            <div class="main_form_title">カクテル検索</div>
            <div class="mr-3 mb-2" style="max-width:1960px">
                <v-layout wrap>
                    <v-flex xs12 md6 class="pr-3 pb-2">
                        <v-layout class="load" style="height: 100%">
                            <v-flex xs1 class="form_column xs_vertical">
                                読み込み
                            </v-flex>
                            <v-flex>
                                <div class="loaddiv">
                                    <div class="column">
                                        <v-btn small @click="saveUser()">保存</v-btn>
                                    </div>
                                    <v-flex>
                                        現在のチェック状況を保存(持っているお酒の状況を保存するのに使います)
                                    </v-flex>
                                </div>
                                <div class="loaddiv">
                                    <div class="column">
                                        <v-btn small v-bind:disabled="!this.is_can_loadUser" @click="loadUser()">読み込み</v-btn>
                                    </div>
                                    <v-flex>
                                        保存したデータを読み込みます。
                                    </v-flex>
                                </div>
                                <div class="loaddiv">
                                    <div class="column">
                                        <v-btn small v-bind:disabled="!this.is_can_loadInstant" @click="loadInstant()">リロード</v-btn>
                                    </div>
                                    <v-flex>
                                        前回の検索条件を読み込みます。
                                    </v-flex>
                                </div>
                                <div class="loaddiv">
                                    <div class="column">
                                        <v-btn small @click="init()">リセット</v-btn>
                                    </div>
                                    <v-flex>
                                        初期状態に戻します
                                    </v-flex>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                    <v-flex xs12 md6>
                        <v-container class="pr-3 pb-2">
                            <v-layout class="searchMethod" style="height: 100%">
                                <v-flex xs1 class="form_column xs_vertical">
                                    検索方法
                                </v-flex>
                                <v-flex>
                                    <div class="searchMethoddiv">
                                        <div class="column">
                                            <input type="radio" name="searchMethod" v-model="searchMethod" value="or">OR検索
                                        </div>
                                        <v-flex>
                                            チェックした「いずれか」が含まれているカクテルを検索
                                        </v-flex>
                                    </div>
                                    <div class="searchMethoddiv">
                                        <div class="column">
                                            <input type="radio" name="searchMethod" v-model="searchMethod" value="and">AND検索
                                        </div>
                                        <v-flex>
                                            チェックした「すべて」が含まれているカクテルを検索
                                        </v-flex>
                                    </div>
                                    <div class="searchMethoddiv">
                                        <div class="column">
                                            <input type="radio" name="searchMethod" v-model="searchMethod" value="having">あるもの検索
                                        </div>
                                        <v-flex>
                                            「チェックが入ったものだけ」で作れるカクテルを検索("その他"は省略可能なので無視されます)
                                        </v-flex>
                                    </div>
                                    <div class="searchMethoddiv">
                                        <div class="column">
                                            <input type="checkbox" name="easily" v-model="easily">かんたん検索
                                        </div>
                                        <v-flex>
                                            材料が少なく(3つ以下)簡単に作れるレシピのみに絞ります
                                        </v-flex>
                                    </div>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-flex>
                </v-layout>

                <v-layout>
                    <v-flex xs12>
                        <v-layout class="mr-3 mb-2">
                            <v-flex xs1 class="form_column xs_vertical">
                                製法
                            </v-flex>
                            <v-flex>
                                <div>
                                <div class="ml-2 method_column" v-for="method in this.methods">
                                    <input v-model="checkedMethods" type="checkbox" :value="method.method_id">
                                    <font-awesome-icon class="fa-fw" v-if="method.method_id==1" :icon="['fas', 'slash']" />
                                    <font-awesome-icon class="fa-fw" v-else-if="method.method_id==2" :icon="['fas', 'fill-drip']" />
                                    <font-awesome-icon class="fa-fw" v-else-if="method.method_id==3" :icon="['fas', 'glass-martini-alt']" />
                                    <font-awesome-icon class="fa-fw" v-else-if="method.method_id==4" :icon="['fas', 'blender']" />
                                    <font-awesome-icon class="fa-fw" v-else-if="method.method_id==5" :icon="['fas', 'glass-whiskey']" />
                                    <font-awesome-icon class="fa-fw" v-else-if="method.method_id==6" :icon="['fas', 'mug-hot']" />
                                    <span>{{method.method_name}}</span>
                                </div>
                                </div>
                                <v-alert
                                    v-if="validateObj.errors.first('method')"
                                    dense
                                    outlined
                                    type="error"
                                >
                                    {{validateObj.errors.first('method').replace( 'method', '製法' )}}
                                </v-alert>
                            </v-flex>
                        </v-layout>
                    </v-flex>

                </v-layout>
            </div>

            <v-layout class="recipe_title_container">
                <div class="recipe_title  xs_vertical">
                    レシピ選択
                </div>
                <v-flex>
                    <div class="d-inline recipe_methodDiv" @click="check_all">全てチェック</div>
                    <div class="d-inline recipe_methodDiv" @click="check_disall">全てはずす</div>
                    <div class="d-inline recipe_methodDiv" @click="check_majorSwit">メジャーでない項目の表示／非表示</div>
                </v-flex>
            </v-layout>
            <div class="disFlex" v-for="(bigcategory , key) in this.kind_and_categories_aiu" v-bind:key="bigcategory.id">
                <v-layout class="kind_wrapper kind" :class="setClassForKind(key)">
                    <v-layout class="kind_title v-layoutCentering xs_vertical">
                        {{dispBigCategoryName(key)}}
                    </v-layout>
                    <v-flex>
                        <v-layout wrap>
                            <v-flex v-show="category.isMajor||isDisplayNonMajor" xs12 sm6 md3 lg2 class="pb-5" v-for="category in bigcategory" v-bind:key="category.id">
                                <input type="checkbox" name="category[]" :value=category.id v-model="checkedCategories" v-bind:value="{id: category.id}" v-on:click="clickedCategory(category.id)"><span class="link" @click="jumpCategoryAndCloseModal(category.id)">{{category.name}}</span><br>
                                <v-layout v-show="middle.isMajor||isDisplayNonMajor" v-for="middle in category.middle" v-bind:key="middle.id">
                                    <div>└</div><div><input type="checkbox" name="middle[]" :value=middle.id v-model="checkedMiddles" v-bind:value="{id: middle.id}" @click.stop="checkParent(category.id)"></div>
                                    <v-flex>
                                        <span class="link" @click="jumpMiddleAndCloseModal(middle.id)">{{middle.name}}</span>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-flex>
                </v-layout>
                <div class="kind_border"></div>
            </div>
            <v-alert
                v-if="validateObj.errors.first('category')"
                dense
                outlined
                type="error"
            >
                {{validateObj.errors.first('category').replace( 'category', 'カテゴリ' )}}
            </v-alert>
            <v-btn x-large rounded color="primary" v-on:click="exeSearch" v-bind:disabled="validateObj.fails()" v-bind:class="{ sendBtnFixed: is_modal }"><div v-if="!this.is_searching" >検索</div><v-progress-circular
                indeterminate
                color="purple"
                v-else
            ></v-progress-circular></v-btn>
        </v-form>
    </div>
</template>

<script>
    import Helper from "../../../../Modules/helper"
    import cocktailSearchClass from "../../../../Modules/cocktailSearchClass"
    import { mapState } from 'vuex'
    import localStorageHelper from"../../../../Modules/localStorageHelper"
    import errors from "../../../Errors/search"
    import { VueLoading } from 'vue-loading-template'
    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        mixins: [errors],components:[VueLoading],
        props:{
           is_modal:false
        },
        data:function(){
            return{
                isDisplayNonMajor:false,
                checkedCategories:[  ],
                checkedMiddles:[  ],
                checkedMethods:[  ],

                //フォーム初期値
                searchMethod:"or",
                easily:false,

                //その他
                is_saved:false,//苦し紛れに定義した値
                is_instant_saved:false,//苦し紛れに定義した値2

                is_searching:false
            }
        },
        created:function(){
            //Vuexアクションを呼び出す
            this.$store.dispatch('form/getAndSetCategories');
        },
        mounted:function(){
            //フォームの初期値を設定する

            this.$store.subscribe((mutation, state) => {
                if (mutation.type === 'form/setResult') {
                    //フォームに必要な部品の取得が終わったので、フォームに埋め込む
                    this.init()
                }

                //結果取得の監視(検索をVuexで行っているため)
                else if (mutation.type === 'cocktailform/setResult') {
                    //結果が取得できたらこれが発火する。
                    //もし結果表示画面でない場合、結果表示画面に飛ばす。
                    console.log("routename is :"+this.$route.name)
                    if(this.$route.name !== 'SearchCocktailResult') {
                        this.$router.push({name: 'SearchCocktailResult'});//結果表示画面に飛ばす
                    }
                    this.$emit('closeForm');//親コンポーネントにダイアログを閉じさせる
                }
            })
        },
        computed: {
            ...mapState("form",{
                categories:state=>state.categories,
                methods:state=>state.methods,
                kinds:state=>state.kinds,
            }),
            closedisplay:function(){
                if(this.kind_and_categories_aiu){
                    return "block"
                }else{
                    return "none";
                }
            },
            kind_and_categories_aiu:function(){
                //カテゴリごとに抽出し、さらにその内部であいうえお順にする
                if(!this.categories){return}//Cannot read property 'slice' of undefined"
                var result = {};//配列だと0キーが出現してしまうのでオブジェクト...

                //まずは大カテゴリごとに分類する
                this.categories.map(function (value,key) {
                    if(!result[value.kind]){result[value.kind]=[];}//存在しないキーであれば配列を作成する
                    result[value.kind].push(value);
                });
                var result2={};

                //Object版foreach
                Object.keys(result).forEach(function (key) {
                    result[key].sort((a, b) => {
                        //「ベース」と「名前」はひらがなとカタカナを統一する(これもバグるため)
                        var a_ = Helper.katakanaToHiragana(a.name.toString());
                        var b_ = Helper.katakanaToHiragana(b.name.toString());
                        return (a_ === b_ ? 0 : a_ > b_ ? 1 : -1);
                    });
                    result2[key]=result[key];
                });
                return result2;

            },

            //バリデーション定義
            validateObj:function(){
                let data = {
                    method:this.checkedMethods,
                    category:this.checkedCategories,
                };

                let rules = {
                    method: 'required',
                    category: 'required',
                };
                var v=new Validator(data, rules);
                v.fails();//ここでバリデーションを実行しオブジェクトの状態を更新しているみたい
                return v;
            },

            //ローカルストレージ関連
            is_can_loadUser:function(){
                return !!localStorageHelper.loadUser() || this.is_saved;
            },
            is_can_loadInstant:function(){
                return !!localStorageHelper.loadInstant() || this.is_instant_saved;
            }

        },
        methods:{
            init(){
              //初期状態にする
                this.methods.forEach(method => {
                    //switch (method.method_name) {
                    //    case "ビルド":
                    //    case "ステア":
                    //    case "シェイク":
                    //    case "プース・カフェ":
                            this.checkedMethods.push(method.method_id)
                            return true;
                    //    default:
                    //        return false;
                    //}
                });
                this.checkedCategories=[]
                this.checkedMiddles=[]
                //this.checkedMethods=[]//これは↑でやってるから入れないようにね
                this.searchMethod="or"
                this.easily=false
            },
            dispBigCategoryName(int){
                //大カテゴリを表示する
                if (!this.kinds){return}//←一応...null参照起きるので...
                var found = this.kinds.find(v => v.id == int)
                return found.name
            },
            setClassForKind(kindId){
                return "kind_"+kindId;
            },
            check_all:function(){
                //すべてにチェックを入れる
                console.log("clicked")
                var result=[];var resultMiddle=[];
                this.categories.map(function (value) {
                    if(!this.isDisplayNonMajor && !value.isMajor){return;}//非メジャーカテゴリ非表示の場合、非メジャーに関しては触れる必要がない
                    result.push(value.id);//まずはメジャーカテゴリに入れる

                    //ミドルカテゴリも同様　リレーションで取ってるのでここで回す
                    value.middle.map(function (value) {
                        if(!this.isDisplayNonMajor && !value.isMajor){return;}//非メジャーカテゴリ非表示の場合、非メジャーに関しては触れる必要がない
                        resultMiddle.push(value.id);
                    },this);
                },this);
                this.checkedCategories=result;//結果をそのままぶちこめばOK
                this.checkedMiddles=resultMiddle;//結果をそのままぶちこめばOK
            },
            check_disall:function(){
                //すべてからチェックを外す
                this.checkedCategories=[  ];
                this.checkedMiddles=[  ]
                //return this.check_allexe(false);
            },
            check_majorSwit:function(){
                //メジャーでない項目の表示・非表示
                this.isDisplayNonMajor=!this.isDisplayNonMajor;
            },

            clickedCategory:function(cid){
                //メジャーカテゴリがクリックされたときのイベント
                var category = this.categories.find(c=>{return c.id===cid});
                if (this.checkedCategories.indexOf(cid) >= 0){
                    //チェックを外した時：関連するミドルカテゴリすべてのチェックを外す
                    category.middle.forEach(m =>{
                        this.checkedMiddles.some((v, i)=>{
                            if (v==m.id)  this.checkedMiddles.splice(i,1);
                        });
                    })
                    return
                }else{
                    //チェックを入れた時
                    var middleList = category.middle.filter(c => {
                        return true;//問答無用ですべてにチェックを入れることに仕様変更した
                        //if(c.isMajor){return true}
                        //return this.isDisplayNonMajor;//isMajorではない場合、isDisplay=trueであればtrueでいい
                    });
                    middleList.forEach( m => this.checkedMiddles.push(m.id))
                    return
                }
            },


            checkParent:function(cid){
                //ミドルカテゴリがクリックされた時対応する親カテゴリにもチェックを入れる
                //算出プロパティorウォッチャでやりたかったが、ミドルカテゴリのチェックが全て消えたらメインカテゴリのチェックも外れそうな気がしたのでやめた
                if(! this.checkedCategories.includes(cid)) {
                    this.checkedCategories.push(cid);
                }
            },


            exeSearch:async function(){
                //検索の実行
                if(this.validateObj.fails()){alert("入力項目に誤りがあります");return}
                this.is_searching=true;

                //必要項目は揃っているので、検索開始
                cocktailSearchClass.setCategories(this.checkedCategories)
                cocktailSearchClass.setSearchMethod(this.searchMethod)
                cocktailSearchClass.setEasily(this.easily)
                cocktailSearchClass.setMiddles(this.checkedMiddles)
                cocktailSearchClass.setMethods(this.checkedMethods)

                //console.log(cocktailSearchClass)

                this.saveInstant()//ストレージに保存する

                await this.$store.dispatch('cocktailform/getCocltailList',{cocktailSearchClass:cocktailSearchClass}).catch(() => {
                    // サーバーエラーが発生した
                    this.searchError(3)
                });
                this.is_searching=false;

            },

            jumpCategoryAndCloseModal:function(cid){
                //フォームを閉じてカテゴリ別のページへジャンプ
                this.$router.push({name: 'CategoryDetail',params: { id: cid }});//結果表示画面に飛ばす
                this.$emit('closeForm');//親コンポーネントにダイアログを閉じさせる
            },
            jumpMiddleAndCloseModal:function(mid){
                //フォームを閉じてカテゴリ別のページへジャンプ
                this.$router.push({name: 'MiddleDetail',params: { id: mid }});//結果表示画面に飛ばす
                this.$emit('closeForm');//親コンポーネントにダイアログを閉じさせる
            },


            //ローカルストレージ関連
            generateLocalStorageObj:function() {
                localStorageHelper.generateObj(this.searchMethod, this.checkedMethods, this.checkedCategories, this.checkedMiddles, this.easily);
            },
            setFromLocalStorageObj:function(obj){
                console.log(obj)
                this.searchMethod=obj.searchMethod
                this.checkedMethods=obj.methods
                this.checkedCategories=obj.categories
                this.checkedMiddles=obj.middles
                this.easily=obj.is_easily
            },
            saveUser:function(){
                this.generateLocalStorageObj();
                localStorageHelper.saveUser();
                this.is_saved=true;//モジュールにcomputedのりアクティブは効かないらしい
            },
            saveInstant:function(){
                this.generateLocalStorageObj();
                localStorageHelper.saveInstant()
                this.is_instant_saved=true;
            },
            loadUser:function(){
                this.setFromLocalStorageObj(localStorageHelper.loadUser());
            },
            loadInstant:function(){
                //console.log(localStorageHelper.loadInstant())
                this.setFromLocalStorageObj(localStorageHelper.loadInstant());
            }
        }

    }
</script>

<style scoped lang="scss">
@import "../../../mq.scss";



    div.main_form_title{
        font-size:200%;
        font-weight: bold;
        border-left:5px solid #006699;
        border-bottom:2px solid #006699;
        margin-bottom: 10px;
    }

    div.form_column{
        display: flex;
        width:6em;
        min-width: 6em;
        align-items: center;
        justify-content: center;
        border-right: 2px solid #336699;
        border-bottom: 1px solid #336699;
        margin-right:5px;
        font-weight: bold;
    }

    div.load, div.searchMethod{
        div.loaddiv, div.searchMethoddiv{
            @include mqm(sm) {
                margin-bottom:10px;
            }
            @include mq(sm) {
                display:flex;
            }
            div.column{
                min-width:140px;
            }
        }
    }

    div.method_column{
        @include mq(sm) {
                display:inline-block;
        }
    }

    div.recipe_title_container {
        border-left: 3px solid #3399FF;
        border-bottom: 1px solid #3399FF;
        margin-top: 10px;

        div.recipe_title {
            font-size: 125%;
            margin-right: 2em;
        }

        div.recipe_methodDiv{
            margin-left: 2em;
            color:#337ab7;
            &:hover {
                color:#2269b7;
                cursor: pointer;
                text-decoration: underline;
            }
        }
    }

    div.kind_wrapper {
        margin-top:2px;
        margin-bottom: 2px;

        &.kind_1,
        &.kind_2,
        &.kind_3{
            background-color: #DDEEFF;
        }
        &.kind_4{
            background-color: #FFFFFF;
        }
        &.kind_5{
            background-color: #EEE;
        }
    }

    div.kind_title {
        min-width:8em;
        max-width:8em;
        word-wrap: break-word;

        border-right-width: 3px;
        border-right-style: solid;
        margin-right:4px;

        font-weight: bold;

        .kind_1 &,
        .kind_2 &,
        .kind_3 & {
            border-right-color: #6699BB;
        }
        .kind_4 &{
            border-right-color: #99BBEE;
        }
        .kind_5 &{
            border-right-color: #333333;
        }
    }
    div.kind_border{
        border-top: 1px solid #3399BB;
    }
#closeBtn{
    position:fixed;
    top:20px;
    right:35px;
}
.sendBtnFixed{
    position:fixed;
    bottom:35px;
    left:35px;
}

.v-progress-circular {
    margin: 1rem;
}

@include mqm(xs) {
    div.xs_vertical{
        max-width:2em;
        min-width:2em;
        width:2em;
        text-align:center;
    }
}
</style>
