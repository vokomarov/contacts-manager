<template>
    <b-form novalidate @submit="submit">
        <b-card footer-tag="footer" header-tag="header">
            <template v-slot:header>Login</template>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="email"
            >
                <template v-slot:label>Email</template>
                <b-form-input
                    id="email"
                    v-model="email"
                    class="col-md-8"
                    required
                    type="email"
                    :disabled="isLoading"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="password"
            >
                <template v-slot:label>Password</template>
                <b-form-input
                    id="password"
                    v-model="password"
                    class="col-md-8"
                    required
                    type="password"
                    :disabled="isLoading"
                ></b-form-input>
            </b-form-group>

            <b-alert
                variant="warning"
                fade
                dismissible
                :show="message !== ''"
                @dismissed="message = ''"
            >
                <b-icon-exclamation-triangle-fill></b-icon-exclamation-triangle-fill>
                {{ message }}
            </b-alert>

            <template v-slot:footer>
                <div class="form-row">
                    <b-col md="8" offset-md="4">
                        <b-button
                            :disabled="isLoading"
                            type="submit"
                            variant="primary"
                            @click="submit"
                        >
                            Login
                            <b-spinner v-show="isLoading" small></b-spinner>
                        </b-button>
                    </b-col>
                </div>
            </template>
        </b-card>
    </b-form>
</template>

<script>
import axios from 'axios';

export default {
    name: 'LoginForm',
    data: () => {
        return {
            isLoading: false,
            message: '',

            email: '',
            password: '',
        }
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.message = '';

            axios.get('/sanctum/csrf-cookie').then(() => {
                axios.post('/login', {
                    email: this.email,
                    password: this.password,
                }).then(this.success).catch(this.failed).finally(this.loaded)
            }).catch(this.loaded);
        },

        success(res) {
            this.$router.push({name: 'contacts'})
        },

        failed(err) {
            console.log(err.response);

            if (err.response && err.response.data.message) {
                this.message = err.response.data.message
            }
        },

        loaded(res) {
            this.isLoading = false;

            return res;
        }
    },
}
</script>

<style scoped>

</style>
