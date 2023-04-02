<template>
    <div style="border-top:double 3px #399;"class="pt-3">
        <div class="flexdiv">
            <!--
            <div style="width: 100px;">
                <input type="text" class="first" v-model="first" name="first" @keypress="keypush"/>
            </div>
            -->
            <div v-if="select_brand_label!=null" style="flex: 1;"><!--リストがnullであればそもそも表示する必要なし--->
                <v-select
                    :items="select_brand_label"
                    v-model="selectedBrandValue"
                    label="有名な銘柄"
                    item-text="label"
                    item-value="value"
                    dense
                    return-object
                    @change="emitDetail"
                ></v-select>
            </div>
            <div v-else class="pt-2">
                -有名な銘柄を入力して下さい-
            </div>
        </div>

        <NamesAndDescription
            v-if="!selectedBrand || selectedBrand.value==null"
            v-bind:edit-mode="'Brand'"
            v-bind:parent_id="category_id"

            v-bind:name="brand_name"
            v-on:update:name="$emit('update:brand_name', $event)"
            v-bind:name_eng="brand_name_eng"
            v-on:update:name_eng="$emit('update:brand_name_eng', $event)"
            v-bind:strength="brand_strength"
            v-on:update:strength="$emit('update:brand_strength', $event)"
            v-bind:description="brand_description"
            v-on:update:description="$emit('update:brand_description', $event)"
            v-bind:youtube="brand_youtube"
            v-on:update:youtube="$emit('update:brand_youtube', $event)"

            v-bind:youtube_time_hour="brand_youtube_time_hour"
            v-on:update:youtube_time_hour="$emit('update:brand_youtube_time_hour', $event)"
            v-bind:youtube_time_minute="brand_youtube_time_minute"
            v-on:update:youtube_time_minute="$emit('update:brand_youtube_time_minute', $event)"
            v-bind:youtube_time_second="brand_youtube_time_second"
            v-on:update:youtube_time_second="$emit('update:brand_youtube_time_second', $event)"
            v-bind:link_txt="brand_link_txt"
            v-on:update:link_txt="$emit('update:brand_link_txt', $event)"
            v-bind:link_url="brand_link_url"
            v-on:update:link_url="$emit('update:brand_link_url', $event)"
            v-bind:is_major="brand_is_major"
            v-on:update:is_major="$emit('update:brand_is_major', $event)"
            v-bind:is_like="brand_is_like"
            v-on:update:is_like="$emit('update:brand_is_like', $event)"
            v-bind:input_image="brand_input_image"
            v-on:update:input_image="$emit('update:brand_input_image', $event)"
            v-bind:uploadImageUrl="brand_uploadImageUrl"
            v-on:update:uploadImageUrl="$emit('update:brand_uploadImageUrl', $event)"

            ref="newBrand"
        />

    </div>
</template>

<script>
    import Helper from "../../../../Modules/helper"
    import NamesAndDescription from "./NamesAndDescription"
    import newBrandProp from "./NewBrandProp"

    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        components:{NamesAndDescription},
        mixins:[newBrandProp],//ここにオブジェクト、setter,getterを詰め込んでいる
        props:{
            editMode:String,
            category_id:Number,
            middle_id:Number,

            selectedBrand:null,//初期値をここにぶっこむとdataに反映される(はず)

            //initialCategory:null,
            //initialMiddle:null,
        },
        data() {
            return {
                //first:null,
                brands:null
            }
        },
        async created(){
            //銘柄IDと、それに紐付いたカテゴリID、ミドルカテゴリIDを取得
            var {data: {result: {Brands: list}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC + '/api/getBrandListWithCategory')
            this.brands=list;

        },
        computed: {
            selectedBrandValue: {
                get() {
                    return this.selectedBrand;
                },
                set(value) {
                    this.$emit('update:selectedBrand', value);
                }
            },
/*
            select_category:function(){
                return Helper.aiu(Helper.narrow(this.categories,this.first),"name",true);
            },

            select_category_label:function() {
                if(this.select_category === undefined || 0 === Object.keys(this.select_category).length){return}

                return this.select_category.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },*/
            select_brand:function(){
                //選択可能なラベルとvalue値の組み合わせを絞り込む
                if(!this.brands){return{}}
                var brandsList

                if(this.editMode=="Middle"){
                    brandsList=this.brands.filter(element => {
                        if(this.middle_id ) {
                            //ミドルカテゴリの有名な銘柄選択時。もしミドルカテゴリが存在していたら、そこで絞り込む。
                            //「メインカテゴリが同じ」で、かつ「同じミドルカテゴリIDが割り当てられているか、またはまだどこにも属していなければ」OK
                            return (this.category_id==element.category_id && (element.middle_id == this.middle_id || element.middle_id==null))
                        }else{
                            //ミドルカテゴリの有名な銘柄選択で、ミドルIDがない＝新規作成の場合
                            //メインカテゴリが同一で、かつすでに他のミドルカテゴリに属していない銘柄を表示する
                            return ((element.middle_id == null )&& element.category_id == this.category_id)
                        }
                    })
                }else if(this.editMode=="Category"){
                    if(this.category_id ) {
                        //メインカテゴリの有名な銘柄選択時。メインカテゴリが同一であればなんでもいい。
                        brandsList = this.brands.filter(element => {
                            return element.category_id == this.category_id
                        })
                    }else{
                        //メインカテゴリの新規作成時。
                        //これは銘柄は新規作成せざるを得ない。スルー。
                    }
                }

                if (!brandsList) {
                    //空だったらそれで終わりでいい
                    return {}
                }
                brandsList.push({id:null,name:"",name_eng:"新しく作成する"})
                return Helper.aiu(brandsList,"name",true);
            },

            select_brand_label:function() {
                //select_brand(ラベルとvalueを格納した配列)からラベルとvalueのセットを作成する
                if(!this.select_brand || 0 === Object.keys(this.select_brand).length){return null}

                return this.select_brand.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },
            validateObj:function(){
                let data = {
                    selectedBrand:this.selectedBrand,
                };

                let rules = {
                    selectedBrand: 'required',
                };
                var v=new Validator(data, rules);
                v.fails();//ここでバリデーションを実行しオブジェクトの状態を更新しているみたい
                return v;
            },
            validateObjAccess:function(){
                //親のバリデーションオブジェクト参照先。つまり状況に応じて返すオブジェクトを変える。
                if(this.selectedBrand===null || this.selectedBrand.value==null){
                    //ブランドを新規登録する場合(フォームが表示されている場合)
                    return this.$refs.newBrand.validateObj
                }else{
                    //ブランド指定が存在する場合
                    return this.validateObj
                }
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
           /*
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
            */
            /*change_middle(){
            },*/
            /*
            clearMiddle:function(){
                //親カテゴリが手によって(@Select)変えられたら、ミドルカテゴリは消してしまう
                this.selectedMiddleValue=null
                //this.$emit('selectedMiddle',null);//なんかwatch効かないんだけど...
            }*/
            emitDetail(){

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
