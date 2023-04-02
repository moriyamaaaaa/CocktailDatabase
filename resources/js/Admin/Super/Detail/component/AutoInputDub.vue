<template>
    <div v-if="cocktail.recipes" style="padding:10px;">
        <table>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="amount"></td>
            </tr>
            <tr><td><font-awesome-icon v-if="cocktail.method==1" :icon="['fas', 'slash']" />
                <font-awesome-icon v-else-if="cocktail.method==2" :icon="['fas', 'fill-drip']" />
                <font-awesome-icon v-else-if="cocktail.method==3" :icon="['fas', 'glass-martini-alt']" />
                <font-awesome-icon v-else-if="cocktail.method==4" :icon="['fas', 'blender']" />
                <font-awesome-icon v-else-if="cocktail.method==5" :icon="['fas', 'glass-whiskey']" />
                <font-awesome-icon v-else-if="cocktail.method==6" :icon="['fas', 'mug-hot']" /></td>
                <td colspan="3">
                    <router-link :to="{name:'AdminCocktailEdit',params:{id:cocktail.id}}">{{cocktail.name}}</router-link>
                </td>
            </tr>
            <template v-for="r in cocktail.recipes">
                <tr>
                    <td style="border-bottom: 1px solid #666;padding-left: 10px;">{{r.category_name}}</td>
                    <td style="border-bottom: 1px solid #666;padding-left: 10px;">{{r.middle_name}}</td>
                    <td style="border-bottom: 1px solid #666;padding-left: 10px;">{{r.brand_name}}</td>
                    <td class="amount" style="border-bottom: 1px solid #666;padding-left: 10px;">{{r.amount}}</td>
                </tr>
            </template>
        </table>
        <div>
            {{cocktail.description||null}}
        </div>
        <div>
            {{cocktail.note||null}}
        </div>
    </div>
</template>

<script>
    export default {
        name: "AutoInputDub",
        props:{
            cocktail:{
                default:undefined,
                type:Object
            }
        }
    }
</script>

<style lang="scss" scoped>
    table{
        max-width:100%;
        table-layout: fixed;
        word-break: break-all;
        word-wrap: break-word;

        td{
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;

            &.amount{
                width:5em;
            }
        }

        div &{
            width:100%;
        }
    }
</style>
