<template>
    <div id="parent">
        <iframe v-if="this.amzn_assoc_default_search_key"
                width="320"
                height="268"
                :src="iframeUrl">
        </iframe>
    </div>
</template>

<script>
    export default {
        props:{
            amzn_assoc_ad_type:{
                default:"responsive_search_widget"
            },
            amzn_assoc_region:{
                default:"JP"
            },
            amzn_assoc_placement:{
                default:""
            },
            amzn_assoc_search_type:{
                default:"search_widget"
            },
            amzn_assoc_width:{
                default:"300"
            },
            amzn_assoc_height:{
                default:"250"
            },
            amzn_assoc_default_search_category:{
                default:"Grocery"
            },
            amzn_assoc_default_search_key:String,
            amzn_assoc_theme:{
                default:"dark"
            },
            amzn_assoc_bg_color:{
                default:"384D58"
            },
        },
        computed:{
            iframeUrl:function () {
                return process.env.MIX_SENTRY_DSN_PUBLIC+'/amazon/'+this.amzn_assoc_default_search_key
            }
        }

        ,mounted:function(){

        }


    }
</script>

<style scoped lang="scss">
    #parent{
        height:300px;
        width:300px;
        margin:auto;
    }
</style>

