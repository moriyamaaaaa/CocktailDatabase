<template>
    <div>
        <list-component v-bind:items="this.brands" link_name="AdminBrandEdit"></list-component>
    </div>
</template>

<script>
    import ListComponent from "./ListComponent"
    export default {
        props: {
                category_id: {
                    type: Number,
                    default: null
                },
                middle_id: {
                    type: Number,
                    default: null
                },
        },
        data:function(){
            return {
               brands:null
            }
        },
        components: {
            ListComponent
        },
        async created() {
            //カテゴリリストを取得
            var {data:{result:{Brands:list}}}= await axios.post(process.env.MIX_SENTRY_DSN_PUBLIC+'/api/getBrandListWithCategory',this.whereIds)
            this.brands=list
        },
        computed:{
            whereIds:function(){
                return{
                    category_id:this.category_id,
                    middle_id:this.middle_id,
                }
            }
        }
    }
</script>
