<template>
    <tr>
        <td>{{ contact.id }}</td>
        <td>{{ contact.name }}</td>
        <td>{{ contact.lastname }}</td>
        <td>{{ contact.email }}</td>
        <td>{{ contact.company_name }}</td>
        <td>{{ contact.company_job_title }}</td>
        <td>
            <b-button-group size="sm">
                <b-button variant="danger" @click="onDelete">Delete</b-button>
            </b-button-group>
        </td>
    </tr>
</template>

<script>
export default {
    name: 'ContactListItem',
    props: ['contact'],

    methods: {
        onDelete() {
            if (! confirm('Are you really want to delete contact?')) {
                return;
            }

            axios.delete(`/api/contacts/${this.contact.id}`)
                .then(this.deleted)
                .catch(this.failed)
        },

        deleted(res) {
            this.$emit('deleted', {
                id: this.contact.id,
            })
        },
        failed(err) {
            console.log(err)
        },
    },
}
</script>

<style scoped>

</style>
