import Vue from 'vue'
import VueRouter from 'vue-router'
import Loading from 'vue-loading-overlay';
import Dashboard from "./views/dashboard/index";

Vue.use(Loading);
Vue.use(VueRouter)

const routes = [

    { path: '/', name: 'dashboard', component: Dashboard, meta : { label: 'Home' }},
    
];


const router = new VueRouter({
    // base: 'kivicare/wp-admin/admin.php?page=dashboard/',
    // mode: 'history',
    routes,
})

let loader = null;

router.beforeEach((to, from, next) => {
    
    
})
router.afterEach((to, from) => {
    
});


export default router
