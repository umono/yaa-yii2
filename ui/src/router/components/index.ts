import otherRoutes from './other'
import AiRoutes from './other/admin'
import notFound from '@/views/site/NotFound.vue'
import Home from '@/views/site/Index.vue'

import Layout from '@/components/common/Layout.vue'
import AiLayout from '@/components/Admin/AdminLayout.vue'

const routes = [{
    path: '/',
    component: Layout,
    children: [
        {
            path: '',
            component: Home,
        },
        ...otherRoutes,
        {
            path: '/admin/',
            component: AiLayout,
            children: [
                ...AiRoutes
            ]
        },
        {
            path: '/admin/login',
            component: () => import('@/views/Admin/login/Index.vue'),
        },
        {
            path: '/:pathMatch(.*)*',
            name: "NotFound",
            component: notFound,
        }
    ]
},
]
export default routes