<template>
    <div id="breadcrumb_container" v-if="big_category||dictionary_category">
        <div v-if="big_category">
            <font-awesome-icon :icon="['fas', 'compass']" />{{big_category.name}} <span v-if="category">/</span>
            <router-link v-if="category" :to="{ name: 'CategoryDetail', params: { id: category.id }}">
                {{category.name}}
            </router-link>
            <span v-if="middle">/</span>
            <router-link v-if="middle" :to="{ name: 'MiddleDetail', params: { id: middle.id }}">
                {{middle.name}}
            </router-link>
        </div>

        <div v-else-if="dictionary_category">
            <font-awesome-icon :icon="['fas', 'compass']" /><router-link :to="{ name: 'DictionaryIndex'}">
                {{dictionary_category.name}}
            </router-link>
        </div>
    </div>
</template>

<script>
    export default {
        props:{
            "big_category":Object,
            "category":Object,
            "middle":Object,

            "dictionary_category":Object
        }

    }
</script>

<style scoped lang="scss">
div#breadcrumb_container{
    margin:7px;//なんかタイトル文字と重なるので
}
</style>
