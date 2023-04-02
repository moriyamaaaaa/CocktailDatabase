<template>
    <div>
        <div class="flexdiv">
            <div style="flex: 1;">
                <v-select
                    :items="select_kinds_label"
                    v-model="selectedKindValue"
                    label="種類"
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
    //import { mapState } from 'vuex'
    //import Helper from "../../../../Modules/helper"

    const Validator = require('validatorjs');
    Validator.useLang('ja');

    export default {
        props:{
            selectedKind:null,
            editMode:null
        },
        data() {
            return {
                kinds:null,
            }
        },
        async created(){
            if(this.editMode=="Dictionary"){
                this.kinds = [
                    {label:"製法",value:"glass"},
                    {label:"グラス",value:"glass"},
                    {label:"カクテル分類",value:"cocktailCategory"},
                ]
            }else{
                var {data: {result: {Kinds: list}}} = await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC + '/api/getKindList')
                this.kinds = list/*.reduce((obj, data) => ({...obj, [data.id]: data}), {});*///配列をオブジェクトに変形している
            }
        },
        watch: {
        },
        computed: {
            selectedKindValue: {
                get() {
                    return this.selectedKind;
                },
                set(value) {
                    this.$emit('update:selectedKind', value);
                }
            },
            select_kinds_label:function() {
                if(this.kinds === null || 0 === Object.keys(this.kinds).length){return}
                return [{label:"選択してください",value:null}].concat(this.kinds.map(v => ({
                    label: v.name + "(" + v.name_eng + ")",
                    value: v.id,
                })))
            },

            validateObj:function(){
                let data = {
                    selectedKind:(!this.selectedKind)?this.selectedKind:this.selectedKind.value,
                };

                let rules = {
                    selectedKind: 'required',
                };
                var v=new Validator(data, rules);
                v.fails();//ここでバリデーションを実行しオブジェクトの状態を更新しているみたい
                return v;
            },
        },
        methods:{
        }
    }
</script>

<style scoped lang="scss">
select.category{
    border:1px solid #222;
}
</style>
