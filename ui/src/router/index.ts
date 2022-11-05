import { createRouter, createWebHistory } from 'vue-router'

import allRouter from './components/index'
import Auth from '@/utils/auth'
import { store } from '@/store'



const router = createRouter({
    history: createWebHistory(),
    routes: allRouter,
    scrollBehavior(to, from, savedPosition) {
        const path = to.path.replace('/admin/', '');
        store.dispatch("menuStore/setActiveKey", path);
        if (savedPosition) {
            if (!window.history.state.forward) {
                store.dispatch('theme/toggleRouter', false);
            } else {
                store.dispatch('theme/toggleRouter', true);
            }
        } else {
            store.dispatch('theme/toggleRouter', false);
        }
    }
})

router.beforeEach((to, from, next) => {
    const aiPage = /^\/admin\/(.*?)/.test(to.path);
    if (to.path != '/admin/login') {
        if (aiPage) {
            if (Auth.getAccessToken()) {
                next();
            } else {
                next({
                    path: '/admin/login',
                    query: {
                        redirect: to.fullPath
                    }
                })
            }
        } else {
            next();
        }
    } else {
        if (Auth.getAccessToken()) {
            next("/admin/");
        } else {
            next()
        }
    }
})



export default router