
const routeKeys = [
    'home',
    'admin',
    'admin-group',
    'admin-log',
    'user',
    'menu',
];

const handlerKeys: any[] = [];
routeKeys.forEach(element => {
    const modules = import.meta.glob('./../../../../views/Admin/*/Index.vue');
    handlerKeys.push(
        {
            path: element,
            name: element.toUpperCase(),
            component: modules[`../../../../views/Admin/${element}/Index.vue`]
        }
    )
});


const routes: any[] = [
    {
        path: '',
        redirect: '/admin/home'
    },
]


export default routes.concat(handlerKeys)