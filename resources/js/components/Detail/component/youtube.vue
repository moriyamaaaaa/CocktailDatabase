<template>
    <div class="youtube_sizing_box" v-if="this.urlID">
        <iframe width="560" height="315" :src="url" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><br>
    </div>
</template>

<script>
    import common from "../../CommonMixins/Common"
    export default {
        props:{
            urlID:undefined,
            hour:{
                default:0
            },
            minute:{
                default:0
            },
            second:{
                default:0
            }
        },
        mixins:[common],
        computed:{
            url:function () {
                var base=this.youtubeURL(this.urlID);
                if(!this.hour && !this.minute && !this.second){
                    return base;
                }
                var computed_second=this.hour*3600+this.minute*60+this.second;
                return base + "?start="+computed_second
            }
        }
    }
</script>

<style scoped lang="scss">
    div.youtube_sizing_box{
        position: relative;
        width: 100%;
        padding-bottom: 56.25%;
    }
    div.youtube_sizing_box iframe{
        position: absolute;
        top: 0;
        right: 0;
        width: 100% !important;
        height: 100% !important;
    }
</style>
