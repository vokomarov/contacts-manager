<template>
    <b-form novalidate @submit.prevent="submit">
        <b-card header-tag="header" footer-tag="footer">
            <template v-slot:header>
                Create New Contact
            </template>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="name"
            >
                <template v-slot:label>Name</template>
                <b-form-input
                    id="name"
                    v-model="form.name"
                    class="col-md-8"
                    required
                    type="text"
                    :disabled="isLoading"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="lastname"
            >
                <template v-slot:label>Last Name</template>
                <b-form-input
                    id="lastname"
                    v-model="form.lastname"
                    class="col-md-8"
                    required
                    type="text"
                    :disabled="isLoading"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="email"
            >
                <template v-slot:label>Email</template>
                <b-form-input
                    id="email"
                    v-model="form.email"
                    class="col-md-8"
                    required
                    type="email"
                    :disabled="isLoading"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="company_name"
            >
                <template v-slot:label>Company Name</template>
                <b-form-input
                    id="company_name"
                    v-model="form.company_name"
                    class="col-md-8"
                    required
                    type="text"
                    :disabled="isLoading"
                ></b-form-input>
            </b-form-group>

            <b-form-group
                label-align-md="right"
                label-cols-md="4"
                label-for="company_job_title"
            >
                <template v-slot:label>Company Job Title</template>
                <b-form-input
                    id="company_job_title"
                    v-model="form.company_job_title"
                    class="col-md-8"
                    required
                    type="text"
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
                <span v-html="message"></span>
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
                            Create
                            <b-spinner v-show="isLoading" small></b-spinner>
                        </b-button>
                        <b-button
                            :disabled="isLoading"
                            :to="{name: 'contacts'}"
                            variant="secondary"
                        >Cancel</b-button>
                    </b-col>
                </div>
            </template>
        </b-card>
    </b-form>
</template>

<script>
import axios from 'axios';
import _ from 'lodash';

export default {
    name: 'ContactCreate',

    data: () => {
        return {
            isLoading: false,
            message: '',

            form: {
                name: '',
                lastname: '',
                email: '',
                company_name: '',
                company_job_title: '',
            },
        };
    },

    methods: {
        submit() {
            this.isLoading = true;
            this.message = '';

            axios.post('/api/contacts', this.form)
                .then(this.created)
                .catch(this.failed)
                .finally(() => {
                    this.isLoading = false;
                })
        },

        created() {
            this.$router.push({name: 'contacts'})
        },

        failed(err) {
            console.log(err.response);

            if (err.response && err.response.status === 401) {
                this.$router.push({name: 'login'})
            }

            if (err.response && err.response.data.message) {
                this.message = err.response.data.message
            }

            if (err.response && err.response.status === 422) {

                this.message = `<b>${err.response.data.message}</b><br><ul><li>${_.values(err.response.data.errors).join('</li><li>')}</li></ul>`
            }
        },
    },
}
</script>

<style scoped>

</style>
