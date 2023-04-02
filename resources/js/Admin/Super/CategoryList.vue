<template>
    <div>
        <list-component v-bind:items="this.categories" link_name="AdminCategoryEdit"></list-component>
    </div>
</template>

<script>
    import { mapState } from 'vuex'
    import ListComponent from "./ListComponent"
    export default {
        components: {
            ListComponent
        },
        created() {
            //カテゴリリストを取得
            //formで定義されているので流用
            this.$store.dispatch('form/getAndSetCategories');
        },
        computed: {
            ...mapState("form", {
                categories: state => state.categories,
            }),
        }
    }
</script>
