<template>
    <a :href="twitter" class="btn btn-dark ml-auto twitter_button" type="button">
        Login with
        <font-awesome-icon :icon="['fab', 'twitter']" />
    </a>
</template>

<script>
    export default {
        data:function(){
            return {
                twitter:process.env.MIX_SENTRY_DSN_PUBLIC+'/auth/twitter'
            }
        }
    }
</script>
