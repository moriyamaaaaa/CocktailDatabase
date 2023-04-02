<template>
    <div>
        <list-component
            v-bind:is_display_narrow="is_display_narrow"
            v-bind:items="this.middles"
            link_name="AdminMiddleEdit"></list-component>
    </div>
</template>

<script>
    import ListComponent from "./ListComponent"
    export default {
        props:{
            category_id: {
                type: Number,
                default: null
            },
            is_display_narrow:{
                type:Boolean,
                default:true
            }
        },
        data:function(){
            return {
                middles:null
            }
        },
        components: {
            ListComponent
        },
        async created() {
            //カテゴリリストを取得
            var {data:{result:{Middles:list}}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getMiddleListWithCategory',this.whereIds)
            this.middles=list
        },
        computed:{
            whereIds:function(){
                return{
                    category_id:this.category_id,
                }
            }
        }
    }
</script>
