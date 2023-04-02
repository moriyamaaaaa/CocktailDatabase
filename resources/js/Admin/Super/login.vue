<template>
<div>
    ログイン
<!--
    <fvl-form method="post" :data="form" url="/api/login" @submit.prevent="login">
        <fvl-input :value.sync="form.fullname" label="Full Name" name="fullname"required  />
        <fvl-input :value.sync="form.password" label="Password"type="password" name="password" required />


        <fvl-checkbox :checked.sync="form.rememberMe" label="Remember Me?" name="remember" />
        <fvl-submit>Validate</fvl-submit>
    </fvl-form>-->

    <div id="twitter_login">
        <twitter></twitter>
    </div>

</div>
</template>

<script>
    import { FvlForm, FvlInput, FvlCheckbox , FvlSubmit } from 'formvuelar'
    import twitter from "./LoginWithTwitter"
    export default {
        components: {
            twitter,
            FvlForm,
            FvlInput,
            FvlCheckbox,
            FvlSubmit,
        },data() {
            return {
                form: {
                    fullname: '',
                    password: '',
                    rememberMe:false
                },
            }
        },
        created() {
            //this.$store.dispatch('auth/setUserInfo')
        },
        methods: {

        }
    }
</script>

<style lang="scss" scoped>
    //@import '~formvuelar/dist/formvuelar.css';
    div#twitter_login{
        width:100%;
        height:50vh;

        ::v-deep a.twitter_button {
            width:80%;
            height:50%;
        }
    }
</style>
