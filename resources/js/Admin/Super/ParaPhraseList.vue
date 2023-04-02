<template>
    <div>
        <div style="max-width:800px;margin:auto;">
            <!--フォーム-->
            <fvl-form @submit.prevent="" url="" v-if="paraphrases">
                <div class="flexdiv">
                    <div><fvl-input :value.sync="name" label="変換前" name="name" /></div>
                    <div style="width:100px;">
                        <v-select
                        :items="commands"
                        v-model="command"
                        label="command"
                        item-text="label"
                        item-value="value"
                        dense
                    ></v-select></div>


                </div>

                <fvl-input :value.sync="note" label="note" name="note" />
            </fvl-form>
            <CategorySelect
                :edit-mode="'ParaPhrase'"
                            v-bind:initial-category="selectedCategory"
                            v-bind:initial-middle="selectedMiddle"
                            v-bind:initial-brand="selectedBrand"
                            :ref="'ParaPhrase'"
            ></CategorySelect>
        </div>
        <div>
            <list-component v-bind:items="this.paraphrases" link_name="Nothing" :func="setForm" @setForm="setForm($event)"></list-component>
        </div>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import { FvlForm,FvlInput } from 'formvuelar'
    import ListComponent from "./ListComponent"
    //import CategorySelect from "./Detail/component/CategorySelect"
    import CategorySelect from "./Detail/component/RecipeSelect"
    export default {
        data(){
            return {
                paraphrases:null,

                name:null,
                note:null,
                command:null,
                selectedCategory:null,
                selectedMiddle:null,
                selectedBrand:null,

                commands:[
                    {label:"(未選択)", value:""},
                    {label:"強制ホット", value:"hot"}
                ],
            }
        },
        components: {
            ListComponent,CategorySelect,FvlForm,FvlInput
        },
        async created() {
            //カテゴリリストを取得
            this.$store.dispatch('form/getAndSetCategories');//メインカテゴリ&ミドルカテゴリはvuexから拝借
            var {data:{result:{Paraphrases:list}}}= await axios.get(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getParaphrase')
            this.paraphrases=list
        },
        computed:{
            ...mapState("form", {
                categories: state => state.categories,
            }),
        },
        methods:{
            async setForm({name, converted, middle, note, command}){
                //子コンポーネントからパラメータを受け入れるので、更新する
                this.name=name;
                this.note=note;
                this.command=command;

                //convertedは文字列になっちゃってるので、探して取得

                var {data:{result:{
                    converted:convertedName,
                    middle:middleName,
                    categoryId:categoryId,
                    middleId:middleId,
                    brandId:brandId
                }}}=await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/Paraphrase/serachFromWords',{
                    converted:converted,
                    middle:middle
                })
                if(brandId){
                    console.log("ｂらんｄ"+brandId)
                    this.$refs.ParaPhrase.selected_brand={value:brandId}
                }else if(middleId){
                    console.log("みっｄぇ"+middleId)
                    this.$refs.ParaPhrase.selected_middle={value:middleId}
                }else{
                    console.log("かてごｒｙ"+categoryId)
                    this.$refs.ParaPhrase.selectedCategory={value:categoryId}
                }
            },
            forceSelect(categoryStr,categoryMiddle=""){
                //パラフレーズ用
            },
        },
    }
</script>
