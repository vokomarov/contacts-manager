<template>
    <b-container>
        <b-row>
            <b-col md="12">
                <contacts-list></contacts-list>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
import ContactsList from '../Components/Contacts/ContactsList.vue';

export default {
    name: 'login',
    components: { ContactsList },
}
</script>
