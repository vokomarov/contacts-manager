<template>
    <b-container>
        <div class="row">
            <div class="col-md-8 ml-md-auto mr-md-auto">
                <contact-create></contact-create>
            </div>
        </div>
    </b-container>
</template>

<script>
import ContactCreate from '../Components/Contacts/ContactCreate.vue';

export default {
    name: 'login',
    components: { ContactCreate },
}
</script>
