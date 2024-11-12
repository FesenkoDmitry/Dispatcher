import ClientPage from "@p/Client/index.vue";
import AdminPage from "@p/Admin/index.vue";
import MasterPage from "@p/Master/index.vue";
import { createWebHistory, createRouter } from 'vue-router'

const routes = [
    { path: '/', component: ClientPage},
    { path: '/admin', component: AdminPage},
    { path: '/master', component: MasterPage},
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

export default router;