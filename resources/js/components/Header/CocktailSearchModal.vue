<template>
    <v-dialog v-model="show">

        <v-card>
            <v-card-text>

                <cocktailForm @closeForm="show=false" :is_modal="true"></cocktailForm>
            </v-card-text>
            <v-card-actions>

            </v-card-actions>

        </v-card>
    </v-dialog>
</template>

<script>
    import cocktailForm from '../Forms/Search/Cocktail/form.vue'
    import {app} from "../../app"
    export default {
        components: {cocktailForm: cocktailForm},
        props: {
            value: Boolean
        },
        computed: {
            show: {
                get () {
                    return this.value
                },
                set (value) {
                    this.$emit('input', value)
                }
            }
        },
        methods:{
            closeForm(){
                console.log("emitted closeForm")
                this.show=false//closeFormイベントを受け取ったら、モーダルを閉じる
            }
        }
    }
</script>

<style scoped lang="scss">
div#dialogdiv{
    max-height:90vh;
    max-width:90vw;
}

</style>
