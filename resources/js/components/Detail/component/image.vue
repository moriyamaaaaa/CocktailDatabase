<template>
    <div id="parent">
        <div v-if="image_file" id="image_container">
            <img :src="image_file" id="image">
        </div>
        <div v-if="image_file" style="text-align: center">
            <a :href="image_url" v-if="image_url">{{image_txt}}</a>
            <span v-else-if="image_txt">{{image_txt}}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            image_file:undefined,
            image_url:undefined,
            image_txt:undefined,
        }
    }
</script>

<style scoped lang="scss">
    div#parent{
        margin:auto;

        div#image_container{
            margin:auto;
            text-align: center;
        }
    }
    img#image{
        max-width:100%;
        min-width:200px;
        max-height:500px;
    }
</style>
