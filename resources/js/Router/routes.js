const routes = [
    {
        path: '/manage/users',
        component: require('../components/Users/Users.vue').default
    },
    {
        path: '/manage/userd',
        component: require('../components/Users/UserDetail.vue').default
    },
    // {
    //     path: '/manage/roles',
    //     component: require('./components/Roles/Roles.vue').default
    // },
    {
        path: '/manage/roles',
        component: require('../components/Roles/Role_Permission.vue').default
    }
]

export default routes
