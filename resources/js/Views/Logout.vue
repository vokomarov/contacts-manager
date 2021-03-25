<template>
    <b-container>
        <div class="row">
            <div class="col-md-8 ml-md-auto mr-md-auto">
                <b-card footer-tag="footer" header-tag="header">
                    <b-spinner small></b-spinner> Please wait
                </b-card>
            </div>
        </div>
    </b-container>
</template>

<script>
import axios from 'axios';

export default {
    name: 'login',
    mounted() {
        axios.post('/logout').then(() => {
            this.$router.push({name: 'login'})
        })
    }
}
</script>
