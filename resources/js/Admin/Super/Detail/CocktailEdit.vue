<template>
    <div class="flexdiv parentbox">
        <div v-if="dubs && dubs.length>0" class="dubbox">
            <div v-for="dub in dubs">
                <dubs :cocktail="dub"/>
            </div>
        </div>
        <div class="cocktailbox" v-bind:class="{ hasdub: dubs && dubs.length>0 }">
            <template v-if="initErrors&&this.initCocktail">
                <div class="my_error"><a href="../../admin/open" target="_blank">{{this.initCocktail.name}}でエラーが発生しました。</a><br></div>
                <div v-if="initDubs && dubs" class="my_error">★同名のカクテルがあります</div>
                <div v-for="e in initErrors" class="my_error" style="max-width:100vw;">
                    <span v-html="e"></span>
                </div>
            </template>

            <base-select v-bind:edit-mode="editMode"
                             v-bind:selected-category.sync="selectedBase"
                         v-bind:labelname="'ベース'"
                             ref="BaseSelect"
            />
            <br>
            <NameAndDrescription
                v-bind:edit-mode="editMode"
                v-bind.sync="detailEditObj"
                ref="form"
            ></NameAndDrescription>
            <br>


            <!--レシピコンポーネント-->
            <recipelist
                v-if="this.recipes!==undefined"
                v-bind:recipes="this.recipes"
                ref="recipe"
                @recipeCategorySet="setBaseIfNull"
            />

            <div class="senddiv">
                <div class="left">
                    <v-btn large color="blue darken-3" dark @click="send">送信</v-btn>
                </div>
                <div v-if="initCocktail" class="right">
                    <v-btn large color="red darken-3" dark  @click="autoInputSkip()">スキップ</v-btn>
                </div>
                <div v-else-if="this.cocktail_id" class="right">
                    <v-btn large color="red darken-3" dark  @click="deleteExe()">削除</v-btn>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import BaseSelect from "./component/CategorySelect"
    import NameAndDrescription from "./component/NamesAndDescription"
    import validationComponent from "./component/validationComponent"
    import recipelist from "./component/RecipeList"
    import Dubs from "./component/AutoInputDub"

    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        mixins:[validationComponent],
        components: {
            BaseSelect,NameAndDrescription,recipelist,Dubs
        },
        props:{
            cocktail_id:Number,

            initCocktail:{
                type:Object,
                default:undefined,
            },
            initRecipes:{
                type:Array,
                default:undefined,
            },

            initDubs:{
                type:Array,
                default:undefined
            },

            initErrors:{
                type:Array,
                default:undefined
            }
        },
        data() {
            return {
                editMode:"Cocktail",
                selectedBase:null,

                is_draft:false,

                detailEditObj:{
                    name:"",
                    name_eng:"",
                    description:"",
                    sweet_degree:null,
                    rate:null,
                    note:"",
                    method:null,
                    glass:null,
                    ice:null,
                    youtube:"",
                    youtube_time_hour:null,
                    youtube_time_minute:null,
                    youtube_time_second:null,
                    link_txt:"",
                    link_url:"",
                    is_major:false,
                    is_like:false,
                    input_image:null,
                    uploadImageUrl:null,
                },

                recipes:undefined,
                dubs:undefined,
            }
        },
        created(){
            this.$store.dispatch('cocktailEdit/setBrands');//BrandデータをVuexに登録
            this.init(this.cocktail_id)

        },
        watch:{
            'selectedBase.value': function(val,oldVal){
                if(!this.$refs || !this.$refs.recipe || !this.$refs.recipe.$refs){return}
                if(oldVal){return}
                //もし空白から変更されていた場合、レシピの一番上も連動して変えてあげる
                this.$refs.recipe.$refs.recipe[0].selectedCategoryValue={value:this.selectedBase.value}
            },
            'detailEditObj.name': function(newval){
                if(!newval){return}
                this.getDubs();
            },
            'detailEditObj.name_eng': function(newval){
                if(!newval){return}
                this.getDubs();
            },
            '$route' (to, from) {
                // ルートの変更の検知...
                this.init(to.params.id)
            },
        },
        computed:{
            sendObj:function(){
                //PHP側に渡すオブジェクトを整形する
                var data={
                    id:(this.cocktail_id)?this.cocktail_id:null,
                    base:this.selectedBase.value,
                    ...this.detailEditObj,
                    recipes:this.recipeObjs
                }
                if(data.uploadImageUrl) {
                    delete data.uploadImageUrl;//特に必要のないデータ
                }
                return data
            },

            formdata:function(){
                //sendObjをFormData型に変換する
                var bodyFormData = new FormData();
                Object.keys(this.sendObj).forEach( key=> {
                    if (Array.isArray(this.sendObj[key])) {
                        //key=recipes
                        this.sendObj[key].forEach((v, i) => {
                            //v=object,i=0,1,2...
                            if(Object.prototype.toString.call( v ) === "[object Object]"){
                                Object.keys(v).forEach( ii=> {
                                    //ii=amount,brand,category...
                                    var value=this.sendObj[key][i][ii]
                                    if(value) {
                                        bodyFormData.append(`${key}[${i}][${ii}]`, (value)?value:"")  // arrayデータを分割して入れ直す
                                    }
                                    //console.log(`${key}[${i}][${ii}]=${value}`)
                                })
                            }else {
                                //今のとこここは存在しないんだけど
                                bodyFormData.append(key + '[]', v)
                            }
                        })
                    } else {
                        bodyFormData.append(key, (this.sendObj[key]!==undefined && this.sendObj[key]!==null)?this.sendObj[key]:"")
                    }

                })
                return bodyFormData
            },
            recipeObjs:function(){
                var results=[]
                this.$refs.recipe.$refs.recipe.forEach(ref=>{
                    results.push({
                        category:(ref.selected_category)?ref.selected_category.value:null,
                        middle:(ref.selected_middle)?ref.selected_middle.value:null,
                        brand:(ref.selected_brand)?ref.selected_brand.value:null,
                        amount:ref.amount,
                        is_optional:(ref.is_optional)?true:false,
                    })
                })
                return results;
            }
        },
        methods:{
            async init(cid){
                if(cid){
                    //IDがくっついているのでデータ取得
                    try{
                        var {data:{result:{cocktail:cocktail,recipes:recipes}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/admin/get/cocktail',{
                            id:cid
                        })
                    }catch(e){
                        console.log(e)
                    }
                    console.log(cocktail.description)
                    this.is_draft=!cocktail.description
                }else if(this.initCocktail){
                    var cocktail=this.initCocktail;
                    var recipes=this.initRecipes;
                    this.dubs=this.initDubs;
                }else{
                    this.recipes=[];//空配列を渡すことで明示的に
                    return;
                }

                //console.log(cocktail)

                this.detailEditObj.name=cocktail.name
                this.detailEditObj.name_eng=cocktail.name_eng
                this.detailEditObj.description=cocktail.description
                this.detailEditObj.sweet_degree=cocktail.sweet_degree
                this.detailEditObj.rate=cocktail.rate
                this.detailEditObj.note=cocktail.note
                this.detailEditObj.method=cocktail.method
                this.detailEditObj.glass=cocktail.glass
                this.detailEditObj.ice=cocktail.ice
                this.detailEditObj.youtube=cocktail.youtube
                this.detailEditObj.youtube_time_hour=cocktail.y_hour
                this.detailEditObj.youtube_time_minute=cocktail.y_minute
                this.detailEditObj.youtube_time_second=cocktail.y_second
                this.detailEditObj.link_txt=cocktail.image_txt
                this.detailEditObj.link_url=cocktail.image_url
                this.detailEditObj.is_major=cocktail.is_major
                this.detailEditObj.is_like=cocktail.is_like
                this.detailEditObj.uploadImageUrl=cocktail.image

                this.selectedBase={value:cocktail.base,label:""}

                this.recipes=recipes;
                if(cid){this.getDubs();}
            },
            async getDubs(){
                var {data:{result:result}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/duplicate/get',{
                    name:this.detailEditObj.name,
                    name_eng:this.detailEditObj.name_eng,
                    removeId:this.cocktail_id
                })
                this.dubs = result
            },
            setBaseIfNull(event){
                if(!this.selectedBase || !this.selectedBase.value){
                    this.selectedBase={value:event};
                }
            },
            async send(){
                //データを送信する
                //データのバリデーション
                var validateObjs=[]
                this.$refs.recipe.$refs.recipe.forEach(ref=>{
                    validateObjs.push(ref.validateObj)
                })
               if(!this.is_validation([
                   this.$refs.form.validateObj,
                   this.$refs.BaseSelect.validateObj,
                       ...validateObjs
               ])){
                   return
               }


               //レシピかぶり、矛盾のチェック
                var recipes = [];
                var is_validated=false;
                var is_findBase=false;
                this.$refs.recipe.$refs.recipe.forEach((ref)=> {
                    if(!ref.selected_category || !ref.selected_category.value){return}//親カテゴリが入力されていない行は無視
                    if(this.selectedBase.value==ref.selected_category.value){is_findBase=true;}//ベースが親カテゴリで見つかった瞬間OKにする

                    if(recipes.length>0){
                        //console.log(ref)
                        recipes.forEach(v=>{
                            //console.log(v)
                            if(v.c==ref.selected_category.value){
                                //カテゴリが同じものが発見された。危険信号。
                                if(v.m){
                                    //比較対象にミドルカテゴリがある場合
                                    var value=(ref.selected_middle!=null)?ref.selected_middle.value:null
                                    if(v.m!=value){
                                        //console.log(v.m + "&" + value)
                                        //ミドルカテゴリが違うので許容
                                        //console.log("ミドルカテゴリが違うので許容")
                                        return
                                    }
                                }else if(ref.selected_middle!=null){
                                    //比較対象にミドルカテゴリがない
                                    //console.log(v.m + "&" + ref.selected_middle.value)
                                    if(ref.selected_middle.value){
                                        //console.log("逆にこちらにミドルカテゴリが設定されていればOK")
                                        return//逆にこちらにミドルカテゴリが設定されていればOK
                                    }
                                }

                                //ミドルカテゴリまで同じ場合
                                if(v.b){
                                    //比較対象に銘柄がある場合
                                    var value=(ref.selected_brand!=null)?ref.selected_brand.value:null
                                    //console.log(ref.selected_brand)
                                    //console.log(v.b + "&" + value)
                                    if(v.b!=value){
                                        //銘柄が違うので許容
                                        //console.log("銘柄が違うので許容")
                                        return
                                    }
                                }else if(ref.selected_brand!=null){
                                    //console.log("比較対象に銘柄がなく、逆にこちらに銘柄が設定されていればOK")
                                    return//比較対象に銘柄がなく、逆にこちらに銘柄が設定されていればOK
                                }

                                //完全にプロフィールに一致するものがある
                                //console.log("一致")
                                is_validated=true;
                                return
                            }

                        })
                    }
                    recipes.push({c:ref.selected_category.value,
                        m:(ref.selected_middle)?ref.selected_middle.value:null,
                        b:(ref.selected_brand)?ref.selected_brand.value:null})
                });
                if(is_validated){
                    alert("レシピが重複しています！")
                }

                //ベースがどこにも含まれていなければNG
                if(!is_findBase){
                    alert("ベースが見つかりません！")
                    is_validated=true;
                }
                if(is_validated){
                    return;
                }



                //とりあえずamountの真偽はともかくとしてバリデーションはできた
                try{
                    //console.log(...this.formdata.entries())
                    axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/admin/submit/cocktail', this.formdata, {headers: {'Content-Type': 'multipart/form-data'} })
                }catch(error){
                    alert(error.response.data.message);
                    return;
                }

                //特に更新終了を待つ必要はないので、さっさとトップ画面に戻ってしまう
                if(!this.initCocktail){
                    if(this.is_draft){
                        this.$router.push({name: 'AdminCocktailDraftList'});
                    }else{
                        this.$router.push({name: 'AdminCocktailList'});
                    }
                    scrollTo(0, 0);
                }else{
                    //ページ遷移が不能なので、emitで対応する
                    this.autoInputSkip();
                }
            },
            autoInputSkip(){
                this.$emit('exe_autoinput');
                return;
            },
            deleteExe(){
                //カクテルの削除
                axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/delete/cocktail',{
                    id:this.cocktail_id
                })
                this.$router.push({name: 'AdminHome'});//結果表示画面に飛ばす
                scrollTo(0, 0);
            }
        }
    }
</script>

<style scoped lang="scss">
    @import "../../../components/mq.scss";
    div.parentbox{
        //height:100vh;
        width:100%;
        margin:auto;
        @include mqm(xs) {
            //width:200px;
            //width:200%;
            //margin:auto;
        }
    }

    div.dubbox{
        height:100%;
        max-width:50%;
        overflow: scroll;
        flex:1;
        position: fixed;
        top:20px;
        left:0;
        padding-top:20px;
        padding-bottom:20px;
    }

    div.cocktailbox{
        //overflow: scroll;
        //height:100%;
        flex:1;
        padding-top:7px;
        max-width:800px;
        width:100%;
        margin-right:auto;
        margin-left:auto;
        &.hasdub{
            max-width:50%;
            margin-right:0;
        }
    }

    div.senddiv{
        display:flex;

        div.left{
            flex:1;
            text-align: left;
        }
        div.right{
            flex:1;
            text-align: right;
        }
    }
</style>
