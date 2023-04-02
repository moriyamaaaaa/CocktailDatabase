<template>
    <div>
        <div class="flexdiv">
            <div>
                <input type="text" class="first" v-model="first" name="first" @input="change_input"/>
            </div>
            <div style="flex: 1;" class="category">
                <v-select
                    :items="select_category_label"
                    v-model="selectedCategoryValue"
                    label="カテゴリ"
                    item-text="label"
                    item-value="value"
                    dense
                    return-object
                    @change="change_category"
                ></v-select>
            </div>
            <div style="flex: 1;" class="middle">
                <v-select
                    :items="select_middle_label"
                    v-model="selected_middle"
                    label="ミドルカテゴリ"
                    item-text="label"
                    item-value="value"
                    dense
                    return-object
                    @change="change_middle"
                ></v-select>
            </div>
            <div style="flex: 1;" class="brand">
                <v-select
                    :items="select_brand_label"
                    v-model="selected_brand"
                    label="銘柄"
                    item-text="label"
                    item-value="value"
                    dense
                    return-object
                    @change="change_brand"
                ></v-select>
            </div>

            <div>
                <input type="text" class="amount" v-model="amount" name="volume"/>
            </div>
            <div>
                <v-checkbox
                    v-model="is_optional"
                ></v-checkbox>
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
            recipe_no:Number,
            initialCategory:{
                type: Number,
                default: null
            },
            initialMiddle:{
                type: Number,
                default: null
            },
            initialBrand:{
                type: Number,
                default: null
            },
            initial_amount:String,
            initial_is_optional:false

        },
        data() {
            return {
                first:null,

                selected_category:null,
                selected_middle:null,
                selected_brand:null,
                amount:null,
                is_optional:false,
            }
        },
        created(){
            this.selected_category={value:this.initialCategory}
            this.selected_middle={value:this.initialMiddle}
            this.selected_brand={value:this.initialBrand}
            this.amount=this.initial_amount
            this.is_optional=this.initial_is_optional
            //console.log(this.selected_category)
        },
        watch: {
            first: function (f_n, f_o) {
                // この関数は first が変わるごとに実行されます。
                if(!!f_n && f_n.match(/[^a-z]/gi)){
                    //アルファベット以外に変更されたとき→IMEが用いられたとき、イベントが発火しないのでこちらで強引に発火
                    this.change_input()
                }
            },
            'selected_category.value':function (val,oldVal){
                if(this.recipe_no!=1 || oldVal || !val){return}
                //もし「一番頭のレシピ」が空白から変更されていた場合、ベース連動して変えてあげられる可能性があるのでemitで放出
                //console.log("emit" + val)
                //console.log(this)
                this.$emit('recipeCategorySet', val)
            },
        },
        computed: {
            ...mapState("cocktailEdit", {
                categories: state => state.categories,
                middles: state => state.middles,
                brands: state => state.brands
            }),
            validateObj:function(){
                let data = {
                    category:(this.selected_category)?this.selected_category.value:null,
                    middle:(this.selected_middle)?this.selected_middle.value:null,
                    brand:(this.selected_brand)?this.selected_brand.value:null,
                    amount:this.amount,
                    is_optional:this.is_optional
                };

                let rules = {
                    category:(this.recipe_no<=2)?"required|integer|min:1":"integer|min:1",
                    middle:'integer|min:1',
                    brand:'integer|min:1',
                    amount:'required_with:category',
                };
                var v=new Validator(data, rules);
                v.setAttributeNames({
                    middle: [this.editMode,this.recipe_no,'ミドルカテゴリ'].join(''),
                    brand: [this.editMode,this.recipe_no,'銘柄'].join(''),
                    amount: [this.editMode,this.recipe_no,'分量'].join(''),
                    category: [this.editMode,this.recipe_no,'カテゴリ'].join(''),
                });
                v.fails();//ここでバリデーションを実行しオブジェクトの状態を更新しているみたい
                return v;
            },

            selectedCategoryValue: {
                get() {
                    return this.selected_category;
                },
                set(value) {
                    this.selected_category=value;
                }
            },


            select_category_label:function() {
                //console.log(Helper.narrow(this.categories, this.first))
                if(!this.categories){return []}
                return Helper.append_null_select(Helper.narrow(this.categories, this.first).map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                })))
            },

            select_middle_label:function(){
                return Helper.append_null_select(this.select_middle_label_inner)
            },
            select_middle_label_inner:function() {
                if(!this.middles){return []}
                //もしカテゴリが選択されていなければ、入力フォームから探索
                if(!this.selected_category || !this.selected_category.value){
                    return Helper.narrow(this.middles, this.first).map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))}
                return this.middles.filter(v=>{
                    //メインカテゴリが選択済の場合だけは、限定する必要がある
                    return this.selected_category.value==v.category
                }).map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },


            select_brand_label:function(){
                return Helper.append_null_select(this.select_brand_label_inner)
            },
            select_brand_label_inner:function() {
                if(this.brands===undefined){return []}
                //もしカテゴリが選択されていなければ、入力フォームから探索(ミドルカテゴリが選択されていればカテゴリも選択されているので包括できる)
                if(!this.selected_category || !this.selected_category.value){
                    return Helper.narrow(this.brands, this.first).map(v => ({
                        label: v.name + "(" + v.name_eng + ")",
                        value: v.id,
                    }))}
                return this.brands.filter(v=>{
                    if(this.selected_middle && this.selected_middle.value){
                        //middle=nullを含むと、ミドルカテゴリで限定している意味がなくなり矛盾が生じる
                        return this.selected_middle.value==v.middle
                    }
                    if(this.selected_category && this.selected_category.value){
                        return this.selected_category.value==v.category
                    }
                    //特に何も指定されていなければ垂れ流し
                    return true;
                }).map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },
        },
        methods:{
            change_category(){
                this.first=null//これをしないと、選択したいカテゴリが表示すらされない
                this.selected_middle=null
                this.selected_brand=null
            },
            change_middle(){
                this.first=null//これをしないと、選択したいカテゴリが表示すらされない
                if(!this.selected_middle.value){return}
                var selected=this.middles.find(v=>{
                    return v.id==this.selected_middle.value
                })

                if(selected.category){
                    this.selected_category={
                        value: this.categories.find(v=>{
                            return v.id==selected.category
                        }).id
                    }
                }
                this.selected_brand=null
            },
            change_brand(){
                this.first=null//これをしないと、選択したいカテゴリが表示すらされない
                if(!this.selected_brand.value){return}
                var selected=this.brands.find(v=>{
                    return v.id==this.selected_brand.value
                })

                if(selected.category){
                    this.selected_category={
                        value: this.categories.find(v=>{
                            return v.id==selected.category
                        }).id
                    }
                }
                if(selected.middle){
                    this.selected_middle={
                        value: this.middles.find(v=>{
                            return v.id==selected.middle
                        }).id
                    }
                }
            },
            keypush(){
                if(this.first!=null){
                    //なにか文字を打ち込んだ
                    this.change_input()
                }
            },
            change_input(){
                //inputを変えたら全部消す
                console.log("change_input")
                this.selected_category=null;
                this.selected_middle=null
                this.selected_brand=null
                this.amonut=null
                this.is_optional=false
            },
        }
    }
</script>

<style scoped lang="scss">
input.first{
    max-width:2em;
    border:1px solid #222;
}
input.amount{
    max-width:3em;
    border:1px solid #222;
}
select.category{
    border:1px solid #222;
}
    div.category,
    div.middle,
    div.brand{
        min-width: 100px;
    }
</style>
