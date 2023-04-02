<template>
    <div>
        <div class="flexdiv">
            <div style="width: 100px;">
                <input type="text" class="first" v-model="first" name="first" @keypress="keypush"/>
            </div>
            <div style="flex: 1;">
                <v-select
                    :items="select_category_label"
                    v-model="selectedCategoryValue"
                    :label="this.labelname"
                    item-text="label"
                    item-value="value"
                    dense
                    return-object
                    @input="clearMiddle"
                ></v-select>
            </div>
            <div v-if="editMode=='Brand'||editMode=='Recipe'" style="flex: 1;">
                <v-select
                    :items="select_middle_label"
                    v-model="selectedMiddleValue"
                    label="ミドルカテゴリ"
                    item-text="label"
                    item-value="value"
                    dense
                    return-object
                ></v-select>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import Helper from "../../../../Modules/helper"

    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        props:{
            editMode:String,
            labelname:{
                type: String,
                default: "カテゴリ"
            },

            selectedCategory:null,//初期値をここにぶっこむとdataに反映される(はず)
            selectedMiddle:null,
            //brands:null

            //initialCategory:null,
            //initialMiddle:null,

            func:undefined
        },
        data() {
            return {
                first:null,/*
                selectedCategory:this.selectedCategoryProp,
                selectedMiddle:this.selectedMiddleProp,
                brands:this.brandsProp*/
            }
        },
        async created(){
            //フォームの各種ボックス用意
            this.$store.dispatch('form/getAndSetCategories');//メインカテゴリ&ミドルカテゴリはvuexから拝借

        },
        watch: {
            first: function (f_n, f_o) {
                // この関数は first が変わるごとに実行されます。
                if(!!f_n && f_n.match(/[^a-z]/gi)){
                    //アルファベット以外に変更されたとき→IMEが用いられたとき、イベントが発火しないのでこちらで強引に発火
                    this.change_input()
                }
            },
        },
        computed: {
            ...mapState("form", {
                categories: state => state.categories,
            }),
            ...mapState("cocktailEdit", {
                brands: state => state.brands,
            }),
            selectedCategoryValue: {
                get() {
                    return this.selectedCategory;
                },
                set(value) {
                    this.$emit('update:selectedCategory', value);
                }
            },
            selectedMiddleValue: {
                get() {
                    return this.selectedMiddle;
                },
                async set(value) {
                    this.$emit('update:selectedMiddle', value);
                    if(!value){return}//value(選択されたミドルカテゴリ)が空であれば、変なことする必要がない
                    //if(selectedCategoryValue){return}//親カテゴリが選択済であれば
                    this.first=null;//親カテゴリ欄を初期状態に戻したい
                    console.log("middle_change emit parent")

                    //ミドルカテゴリが変更されたら、強制的に親カテゴリを確定させる。
                    Object.keys(this.categories).forEach( (o)=> {
                        if(!this.categories[o].middle){return}
                        Object.keys(this.categories[o].middle).forEach( (m)=>{
                            //console.log(this.selectedMiddleValue)
                            if(this.categories[o].middle[m].id==value.value){
                                this.selectedCategoryValue={value:this.categories[o].id,label:this.categories[o].name+"("+this.categories[o].name_eng+")"}
                            }
                        })
                    });
                }
            },

            allmiddle:function(){
                //Vuexから抜き出してくる
                var result=[]
                if(!this.categories){return null}
                Object.keys(this.categories).forEach( (o)=> {
                    if(!this.categories[o].middle){return}
                    Object.keys(this.categories[o].middle).forEach( (m)=>{
                        result.push(this.categories[o].middle[m])
                    })
                });
                return Helper.aiu(result,"name",true);
            },

            select_category:function(){
                return Helper.aiu(Helper.narrow(this.categories,this.first),"name",true);
            },

            select_category_label:function() {
                if(this.select_category === undefined || 0 === Object.keys(this.select_category).length){return}

                return this.select_category.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },
            select_middle:function(){
                if(this.selectedCategory && this.categories){
                    //もしメインカテゴリが選択されていたら、firstは無視して絞り込む(入力時になんか事故りそうなのでそういう仕様にした)
                    var middles=this.categories.find(element => element.id == this.selectedCategory.value).middle
                    if(!middles){return{}}//空だったらそれで終わりでいい

                }else{
                    //もしメインカテゴリが未選択なら、first(あれば)を用いて絞り込む
                    if(this.first){
                        middles=Helper.narrow(this.allmiddle,this.first);
                    }else{
                        middles = this.allmiddle
                    }
                }
                if(middles){middles.push({id:null,name:"",name_eng:"未選択"})}
                return Helper.aiu(middles,"name",true);
            },

            select_middle_label:function() {
                if(!this.select_middle || 0 === Object.keys(this.select_middle).length){return null}

                return this.select_middle.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },

            validateObj:function(){
                let data = {
                    selectedCategory:this.selectedCategory,
                };

                let rules = {
                    selectedCategory: 'required',
                };
                var v=new Validator(data, rules);
                v.fails();//ここでバリデーションを実行しオブジェクトの状態を更新しているみたい
                return v;
            },
        },
        methods:{
           /* delete_first(is_keep){
                //inputを消す。[is_keep(bool)] : 現在の状態をキープするか
                this.first=null;
                if (!is_keep){
                    change_input()
                }
            },*/
           keypush(){
               if(this.first==null){
                   //文字を空にしたんなら
                   console.log("delete_change_input")
                   this.change_input()
               }else{
                   //なにか文字を打ち込んだ
                   console.log("hit_change_input")
                   this.change_input()
               }
           },
            change_input(){
                //inputを変えたら全部消す
                    this.selectedCategoryValue=null;
                    this.selectedMiddleValue=null
            },
            /*change_middle(){
            },*/
            clearMiddle:function(){
                //親カテゴリが手によって(@Select)変えられたら、ミドルカテゴリは消してしまう
                this.selectedMiddleValue=null
                //this.$emit('selectedMiddle',null);//なんかwatch効かないんだけど...
            }
        }
    }
</script>

<style scoped lang="scss">
input.first{
    max-width:2em;
    border:1px solid #222;
}
select.category{

    border:1px solid #222;
}
</style>
