import VueRouter from 'vue-router';

const routes = [
    {
        path: '',
        component: () => import('./Views/Home.vue'),
        name: 'home',
    },
    {
        path: '/login',
        component: () => import('./Views/Login.vue'),
        name: 'login',
    },
    {
        path: '/logout',
        component: () => import('./Views/Logout.vue'),
        name: 'logout',
    },
    {
        path: '/contacts',
        component: () => import('./Views/Contacts.vue'),
        name: 'contacts',
    },
    {
        path: '/contacts/create',
        component: () => import('./Views/ContactCreate.vue'),
        name: 'contacts.create',
    },
];

const router = new VueRouter({
    mode: 'history',
    routes,
});

export default router;
