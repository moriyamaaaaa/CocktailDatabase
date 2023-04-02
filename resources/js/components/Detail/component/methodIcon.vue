<template>
    <span>
        <font-awesome-icon v-if="methodId==1" :icon="['fas', 'slash']" />
        <font-awesome-icon v-else-if="methodId==2" :icon="['fas', 'fill-drip']" />
        <font-awesome-icon v-else-if="methodId==3" :icon="['fas', 'glass-martini-alt']" />
        <font-awesome-icon v-else-if="methodId==4" :icon="['fas', 'blender']" />
        <font-awesome-icon v-else-if="methodId==5" :icon="['fas', 'glass-whiskey']" />
        <font-awesome-icon v-else-if="methodId==6" :icon="['fas', 'mug-hot']" />
    </span>
</template>

<script>
    export default {
        props:{
            methodId:Number
        }
    }
</script>

<style scoped>

</style>
