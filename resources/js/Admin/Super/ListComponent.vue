<template>
        <div id="container">
            <fvl-form method="post" :data="form" url="" @submit.prevent="" v-if="is_display_narrow">
                <fvl-input :value.sync="input" label="絞り込み" name="input" />
            </fvl-form>
            <div v-if="!is_paraPhrase">
                <div v-for="c in narrow">
                    <router-link :to="{name:link_name,params:{id:c.id}}">{{c.name}}({{c.name_eng}})</router-link><span v-if="append(c)" style="padding-left:15px;">({{append(c)}})</span>
                </div>
            </div>
            <div v-else>
                <div v-for="c in narrow">
                    <a href="#" @click="setForm({name:c.name, converted:c.converted, middle:c.middle, note:c.note, command:c.command})">{{c.name}}</a> → {{c.converted}} <span v-if="c.middle!=''">【{{c.middle}}】</span>
                    <span v-if="c.note"><font-awesome-icon class="fa-fw" :icon="['fas', 'lightbulb']" /></span>
                </div>
            </div>
        </div>
</template>

<script>
    import { FvlForm,FvlInput } from 'formvuelar'
    import Helper from "../../Modules/helper"
    export default {
        components: {
            FvlForm,FvlInput,
        },
        props:{
            items:Array,
            link_name:String,
            is_display_narrow:{
                type:Boolean,
                default:true
            },
            is_draft:{
                type:Boolean,
                default:false
            }
        },
        data() {
            return {
                form:{},
                input:""
            }
        },
        created(){
            this.$store.dispatch('cocktailEdit/setBrands');//レシピコンポーネントで使うデータを取得
        },
        computed: {
            narrow:function(){
               //inputから始まるもので絞り込む
                if(!this.input){return this.aiu}
               return this.aiu.filter( v=> {
                   if(this.is_paraPhrase){
                       return Helper.katakanaToHiragana(v.name).startsWith(Helper.katakanaToHiragana(this.input))
                   }
                   return (Helper.katakanaToHiragana(v.name).startsWith(Helper.katakanaToHiragana(this.input))
                       || Helper.katakanaToHiragana(v.name_eng.toLowerCase()).toLowerCase().startsWith(Helper.katakanaToHiragana(this.input).toLowerCase())
                   )
               })
            },
            aiu: function () {
                //カテゴリごとに抽出し、さらにその内部であいうえお順にする
                return Helper.aiu(this.items,"name",true);
            },
            is_paraPhrase(){
                return this.link_name=="Nothing"
            }
        },
        methods:{
            setForm({name, converted, middle, note, command}){
                this.$emit('setForm',{name:name, converted:converted, middle:middle, note:note, command:command})
            },
            append(item){
                var str="";
                if(this.link_name=="AdminBrandEdit"){
                    if(item.id==item.categorys_famous_id){
                        str+="★"
                    }
                    str+=item.category_name
                    if(item.middle_name){
                        str+="/"

                        if(item.id==item.middles_famous_id){
                            str+="★"
                        }
                        str+=item.middle_name
                    }

                }
                if(this.link_name=="AdminMiddleEdit"){
                    str+=item.parent_name
                    str+="/"+item.parent_name_eng
                }

                return str
            },
        }
    }
</script>



<style scoped lang="scss">
    @import '~formvuelar/dist/formvuelar.css';
    div#container{
        margin:auto;
        max-width:1000px;
    }
</style>
