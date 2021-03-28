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
                <contact-list-item
                    v-for="contact of contacts"
                    :contact="contact"
                    :key="contact.id"
                    @deleted="onDeleted"
                ></contact-list-item>
            </tbody>
        </table>
    </b-card>
</template>

<script>
import axios from 'axios';
import ContactListItem from './ContactListItem';

export default {
    name: 'ContactsList',
    components: { ContactListItem },
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

        onDeleted(event) {
            const index = this.contacts.findIndex(contact => contact.id === event.id)

            if (index === -1) {
                this.load();
                return;
            }

            this.contacts.splice(index, 1)
        }
    },
}
</script>

<style scoped>

</style>
