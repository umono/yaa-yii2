const routes = [
    {
        path: '/test',
        name: 'Test',
        component: () => import('@/views/test/Index.vue'),
    },
]

export default routes