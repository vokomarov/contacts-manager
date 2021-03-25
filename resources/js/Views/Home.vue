<template>
    <b-container>
        <b-jumbotron header="Contacts Manager" lead="Will change your life">
            <p>Allow you to create, list, edit, delete contacts. Very cool, isn't?</p>
            <b-button variant="primary" :to="{name: 'contacts'}">Discover</b-button>
        </b-jumbotron>
    </b-container>
</template>

<script>
export default {
    name: 'home'
}
</script>
