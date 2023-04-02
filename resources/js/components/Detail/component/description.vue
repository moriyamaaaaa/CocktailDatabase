<template>
    <div>
        <span v-for="d in descriptionObject" v-bind:class="{ is_youtube: d.is_youtube }">
            <router-link v-if="d.command==='P'" :to="{ name: 'CategoryDetail', params: { id: d.id }}">{{d.txt}}</router-link>
            <router-link v-else-if="d.command==='M'" :to="{ name: 'MiddleDetail', params: { id: d.id }}">{{d.txt}}</router-link>
            <router-link v-else-if="d.command==='B'" :to="{ name: 'BrandDetail', params: { id: d.id }}">{{d.txt}}</router-link>
            <router-link v-else-if="d.command==='C'" :to="{ name: 'CocktailDetail', params: { id: d.id }}">{{d.txt}}</router-link>
            <router-link v-else-if="d.command==='D'" :to="{ name: 'DictionaryDetail', params: { id: d.id }}">{{d.txt}}</router-link>
            <span v-else v-html="d.txt"></span>
        </span>
    </div>
</template>

<script>
    export default {
        props:{
            "descriptionObject":Array
        }
    }
</script>

<style scoped lang="scss">
    span.is_youtube a{
       color:#FF6600 !important
    }
</style>
