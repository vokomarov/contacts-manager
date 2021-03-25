<template>
    <div class="app">
        <navbar></navbar>

        <div class="app-view">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>
import Navbar from './Components/Navbar.vue';

export default {
    name: 'app',
    components: {
        Navbar,
    },
}
</script>

<style scoped>
    .app-view {
        margin-top: 20px;
    }
</style>
