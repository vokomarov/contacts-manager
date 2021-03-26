<template>
    <b-card header-tag="header">
        <template v-slot:header>
            Contacts
            <b-button variant="primary" size="sm" :to="{name: 'contacts.create'}">Create</b-button>
        </template>

        <table class="table b-table table-sm">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Last name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Job Title</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="contact of contacts">
                    <td>{{ contact.id }}</td>
                    <td>{{ contact.name }}</td>
                    <td>{{ contact.lastname }}</td>
                    <td>{{ contact.email }}</td>
                    <td>{{ contact.company_name }}</td>
                    <td>{{ contact.company_job_title }}</td>
                    <td>
                        <b-button-group size="sm">
                            <b-button variant="primary">Edit</b-button>
                            <b-button variant="danger">Delete</b-button>
                        </b-button-group>
                    </td>
                </tr>
            </tbody>
        </table>
    </b-card>
</template>

<script>
import axios from 'axios';

export default {
    name: 'ContactsList',

    data: () => {
        return {
            contacts: [],
        };
    },

    mounted() {
        this.load();
    },

    methods: {
        load() {
            axios.get('/api/contacts')
                .then(this.loaded)
                .catch(this.failed)
        },

        loaded(res) {
            this.contacts = res.data.data;
        },

        failed(err) {
            console.log(err.response);

            if (err.response && err.response.status === 401) {
                this.$router.push({name: 'login'})
            }
        },
    },
}
</script>

<style scoped>

</style>
