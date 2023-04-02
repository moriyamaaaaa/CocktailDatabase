<template>
    <div class="recipeparent" v-if="this.recipeArray">

        <recipe-column  v-for="(r, key) in recipeArray":key="key"
            :edit-mode="'Recipe'"
            v-bind:initial-category="r.category"
            v-bind:initial-middle="r.middle"
            v-bind:initial-brand="r.brand"
            v-bind:initial_amount="r.amount"
            v-bind:initial_is_optional="r.is_optional"
                        v-bind:recipe_no="key+1"
            @recipeCategorySet="emit"
            :ref="'recipe'"
        />
    </div>
<!--
            @recipeCategorySet=""-->
</template>

<script>
    import recipeColumn from "./RecipeSelect"

    export default {
        components:{recipeColumn},
        props:{
            cocktail_id:Number,
            recipes: {
                type:Array,
                default:undefined
            }
        },
        computed:{
            recipeArray:function(){if(this.recipes===undefined){return undefined}
                var result=this.recipes.slice();

                for(var i=this.recipes.length; i<12; i++) {
                    result.push({
                        amount: null,
                        brand: null,
                        category: null,
                        is_optional: false,
                        middle: null,
                    })
                }
                return result
            },
        },methods:{
            emit(event){
                this.$emit('recipeCategorySet', event);
            }
        }
    }
</script>

<style scoped lang="scss">
    div.recipeparent{
        max-width:100%;
    }
</style>
