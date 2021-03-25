<template>
    <b-container>
        <div class="row">
            <div class="col-md-8 ml-md-auto mr-md-auto">
                <login-form></login-form>
            </div>
        </div>
    </b-container>
</template>

<script>
import LoginForm from '../Components/LoginForm.vue';

export default {
    name: 'login',
    components: {
        LoginForm,
    }
}
</script>
