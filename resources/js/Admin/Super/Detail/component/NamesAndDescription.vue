<template>
    <div>
        <div class="flexdiv" style="max-width: 500px;" v-if="editMode=='Cocktail'">
            <div style="flex: 1;" class="ice">
                <v-select
                    :items="iceLabel"
                    v-model="iceValue"
                    label="氷の有無"
                    item-text="label"
                    item-value="value"
                    dense
                ></v-select>
            </div>
            <div style="flex: 1;" class="glass">
                <v-select
                    :items="glassLabel"
                    v-model="glassValue"
                    label="グラス"
                    item-text="label"
                    item-value="value"
                    dense
                ></v-select>
            </div>
        </div>
        <div class="flexdiv">
            <v-text-field
                :value="name"
                @input="$emit('update:name', $event)"
                :counter="255"
                label="名前"
                :error-messages="(is_hasDuplicate_name)?'[Warn]同じ名前が存在しています':''"
                :error="is_hasDuplicate_name"
                @change="is_hasDuplicate_name_method"
                required
            ></v-text-field>
            <v-text-field
                @change="change_name_eng($event)"
                :value="name_eng"
                :error-messages="(is_hasDuplicate_name_eng)?'[Warn]同じ名前が存在しています':''"
                :counter="255"
                label="Name"
                required
            ></v-text-field>
            <v-text-field v-if="editMode=='Brand'"
                @input="$emit('update:strength',($event)?onlyNumberAndDot($event):'')"
                :value="strength"
                :counter="4"
                label="%"
                required
            ></v-text-field>
        </div>
        <div class="flexdiv" v-if="editMode=='Cocktail'">
            <div style="flex:1;">
                <a :href="meanurl" target="_blank">意味検索</a>
            </div>
            <div style="flex:1;">
                <a :href="wordurl" target="_blank">カクテル言葉検索</a>
            </div>
        </div>

        <div class="flexdiv">
            <div style="flex: 1;" class="method" v-if="editMode=='Cocktail'">
                <v-select
                    :items="methodLabel"
                    v-model="methodValue"
                    label="製法"
                    item-text="label"
                    item-value="value"
                    dense
                ></v-select>
            </div>
            <div style="flex: 1;" class="rate" v-if="editMode=='Cocktail'">
                <v-select
                    :items="rateLabel"
                    v-model="rateValue"
                    label="評価"
                    item-text="label"
                    item-value="value"
                    dense
                ></v-select>
            </div>
            <div style="flex: 1;" class="sweet_degree" v-if="editMode=='Cocktail'">
                <v-select
                    :items="sweetdegreeLabel"
                    v-model="sweetDegreeValue"
                    label="甘さ"
                    item-text="label"
                    item-value="value"
                    dense
                ></v-select>
            </div>
            <input type="checkbox" :checked="is_major"
                   @change="$emit('update:is_major', !!$event)">メジャー
            <input type="checkbox" :checked="is_like" v-if="editMode!='Cocktail'"
                   @change="$emit('update:is_like', !!$event)">お気に入り
            <input type="checkbox" :checked="is_powder" v-if="editMode=='Middle' || editMode=='Category'"
                   @change="$emit('update:is_powder', !!$event)">粉もの
        <!--<v-checkbox
            :value="is_major"
            @change="$emit('update:is_major', !!$event)"
            label="メジャー"
        ></v-checkbox>
            <v-checkbox
                v-if="editMode!='Cocktail'"
                :value="is_like"
                @change="$emit('update:is_like', $event)"
                label="お気に入り"
            ></v-checkbox>
            <v-checkbox
                v-if="editMode=='Middle' || editMode=='Category'"
                :value="is_powder"
                @change="$emit('update:is_powder', $event)"
                label="粉もの"
            ></v-checkbox>-->
        </div>
        <v-textarea
            outlined
            @input="$emit('update:description', $event)"
            :value="description"
            label="説明"
        ></v-textarea>
        <v-textarea
            v-if="editMode=='Cocktail'"
            outlined
            @input="$emit('update:note', $event)"
            :value="note"
            label="補足"
        ></v-textarea>
        <div class="flexdiv">
            <v-text-field
                @input="$emit('update:youtube', $event)"
                :value="youtube"
                :counter="255"
                label="Youtube"
            ></v-text-field>
            <v-text-field
                @change="$emit('update:youtube_time_hour',  ($event)?onlyNumber1digit($event):'')"
                :value="youtube_time_hour"
                :counter="1"
                label="時"
            ></v-text-field>
            <v-text-field
                @change="$emit('update:youtube_time_minute',  ($event)?onlyNumber2digit($event):'')"
                :value="youtube_time_minute"
                :counter="2"
                label="分"
            ></v-text-field>
            <v-text-field
                @change="$emit('update:youtube_time_second',  ($event)?onlyNumber2digit($event):'')"
                :value="youtube_time_second"
                :counter="2"
                label="秒"
            ></v-text-field>
        </div>
<div class="img_container">
        <img class="preview" v-if="uploadImageUrl" :src="uploadImageUrl" />
        <v-file-input
            v-if="input_image!==undefined"
            :value="input_image"
            accept="image/*"
            show-size
            label="画像ファイルをアップロードしてください"
            prepend-icon="mdi-image"
            @change="onImagePicked($event)"
        ></v-file-input>
</div>
        <div class="flexdiv">
            <v-text-field
                @input="$emit('update:link_txt', $event)"
                :value="link_txt"
                :counter="255"
                label="リンクテキスト"
            ></v-text-field>
            <v-text-field
                @input="$emit('update:link_url', $event)"
                :value="link_url"
                :counter="400"
                label="リンクURL"
            ></v-text-field>
        </div>
    </div>

</template>

<script>
    import Helper from '../../../../Modules/helper'
    import { mapState } from 'vuex'

    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        props:{
            editMode:String,
            //detailEditObj:Object,
            parent_id:Number,

            name:String,
            name_eng:String,
            strength:null,//""じゃなくて0を送れ！ってWarnがウザいから消した
            description:String,
            note:String,
            youtube:String,
            youtube_time_hour:Number,
            youtube_time_minute:Number,
            youtube_time_second:Number,

            link_txt:String,
            link_url:String,

            is_major:Boolean,
            is_like:Boolean,
            is_powder: {
                type: Boolean,
                default: false
            },

            ice: {
                type: Number,
                default: null
            },
            method: {
                type: Number,
                default: null
            },
            glass: {
                type: Number,
                default: null
            },
            rate: {
                type: Number,
                default: null
            },
            sweet_degree: {
                type: Number,
                default: null
            },

            input_image:null,
            uploadImageUrl: String
        },
        data(){
            return{
                valid: false,
                is_hasDuplicate_name:false,
                is_hasDuplicate_name_eng:false,
            }
        },
        computed:{
            ...mapState("cocktailEdit", {
                glasses: state => state.glasses,
                ices: state => state.ices,
                methods: state => state.methods,
            }),
            wordurl:function(){
                return "https://www.google.co.jp/search?q="+this.name+" カクテル言葉";
            },
            meanurl:function(){
                return "https://www.google.co.jp/search?q="+this.name_eng+" %E6%84%8F%E5%91%B3";
            },
            glassLabel:function() {
                if(!this.glasses){return []}
                return Helper.append_null_select(this.glasses.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                })))
            },
            iceLabel:function() {
                if(!this.ices){return []}
                return Helper.append_null_select(this.ices.map(v => ({
                    label: v.name,
                    value: v.id,
                })))
            },
            methodLabel:function() {
                if(!this.ices){return []}
                return this.methods.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                }))
            },

            iceValue: {
                get() {
                    return this.ice;
                },
                set(value) {
                    this.$emit('update:ice', value);
                }
            },
            glassValue: {
                get() {
                    return this.glass;
                },
                set(value) {
                    this.$emit('update:glass', value);
                }
            },
            methodValue: {
                get() {
                    return this.method;
                },
                set(value) {
                    this.$emit('update:method', value);
                }
            },
            rateValue: {
                get() {
                    return this.rate;
                },
                set(value) {
                    this.$emit('update:rate', value);
                }
            },
            sweetDegreeValue: {
                get() {
                    return this.sweet_degree;
                },
                set(value) {
                    this.$emit('update:sweet_degree', value);
                }
            },

            rateLabel:function() {
                return Helper.append_null_select([5,4,3,2,1].map(v => ({
                    label: v,
                    value: v,
                })))
            },
            sweetdegreeLabel:function() {
                if(!this.ices){return []}
                return Helper.append_null_select([...Array(21).keys()].map(i => i-10).map(v => ({
                    label: v,
                    value: v,
                })))
            },
            //バリデーション定義
            validateObj:function(){
                let data = {
                    name:this.name,
                    name_eng:this.name_eng,
                    strength:this.strength,
                    description:this.description,
                    method:this.method,
                };

                let rules = {
                    name: 'required',
                    name_eng: 'required',//変な文字も通したいので、alphabetは使わない
                    strength: (this.editMode=="Brand")?'required|numeric':"numeric",
                    description: (this.editMode!="Cocktail")?'required':"string",
                    method: (this.editMode=="Cocktail")?'required':"",
                };
                var v=new Validator(data, rules);
                v.setAttributeNames({
                    name: this.editMode+'_name',
                    name_eng: this.editMode+'_name_eng',
                    strength: this.editMode+'_strength',
                    description: this.editMode+'_description'
                });
                v.fails();//ここでバリデーションを実行しオブジェクトの状態を更新しているみたい
                return v;
            },
        },
        methods:{
            big_to_hankaku(str){
                return Helper.Big_to_hankaku(str)
            },
            onlyNumberAndDot(str){
                var newValue=Helper.onlyNumberAndDot(str)
              return newValue
            },
            onlyNumber2digit(str){
                //2桁までしか許容しない＆小数点削除
                return Number(Helper.onlyNumberAndDot(str).toString().replace(/[\.]/g, '').slice(0,2))
            },
            onlyNumber1digit(str){
                //2桁までしか許容しない＆小数点削除
                return Number(Helper.onlyNumberAndDot(str).toString().replace(/[\.]/g, '').slice(0,1))
            },


            is_hasDuplicate_name_method:function(){
                var a= this.checkDuplicateName(this.name,false)
            },
            is_hasDuplicate_name_eng_method:function(event){
                return this.checkDuplicateName(event,true)
            },
            async checkDuplicateName(str,is_eng){
                //名前がダブってないかチェック
                if(!str){return false;}//空白ならスルー
                console.log(str)
                try{
                    var {data:{result:{is_duplicate:result}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/Cocktail/duplicate/check',{
                        command:this.editMode,
                        is_eng:is_eng,
                        str:str,
                        parent:(this.editMode=="Middle"||this.editMode=="Brand")?this.parent_id:null
                    })
                }catch(e){
                    console.log(e)
                }
                if(is_eng){
                    this.is_hasDuplicate_name_eng=result;
                }else{
                    this.is_hasDuplicate_name=result;
                }
                return;
            },

            change_name_eng(event){
                this.$emit('update:name_eng', (event)?this.big_to_hankaku(event):'')
                this.is_hasDuplicate_name_eng_method(event)
            },


            onImagePicked(file) {
                if (file !== undefined && file !== null) {
                    if (file.name.lastIndexOf('.') <= 0) {
                        return
                    }
                    const fr = new FileReader()
                    fr.readAsDataURL(file)
                    fr.addEventListener('load', () => {
                        this.$emit('update:uploadImageUrl', fr.result)
                        this.$emit('update:input_image', file)
                    })
                } else {
                    this.$emit('update:uploadImageUrl', '')
                    this.$emit('update:input_image', null)
                }

            },
        }
    }
</script>

<style scoped lang="scss">
    div.img_container{
        text-align:center;

        img.preview{
            max-height:350px;
            max-width:100%;
            margin:auto;

        }
    }

    div.method,
    div.rate,
    div.sweet_degree{
        max-width:100px;
    }
</style>
