<template>
    <b-navbar variant="light">
        <b-container>
            <b-navbar-brand :to="{name: 'home'}">Contacts Manager</b-navbar-brand>

            <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

            <b-collapse id="nav-collapse" is-nav>
                <b-navbar-nav>
                    <b-nav-item :to="{name: 'contacts'}" exact-active-class="active">Contacts</b-nav-item>
                </b-navbar-nav>

                <b-navbar-nav class="ml-auto">
                    <b-navbar-nav>
                        <b-nav-item :to="{name: 'login'}" exact-active-class="active">Login</b-nav-item>
                        <b-nav-item :to="{name: 'logout'}">Logout</b-nav-item>
                    </b-navbar-nav>
                </b-navbar-nav>
            </b-collapse>
        </b-container>
    </b-navbar>
</template>

<script>
export default {
    name: 'navbar',
}
</script>
