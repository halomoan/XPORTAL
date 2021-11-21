import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: "/admin/users",
        component: require("./components/Users.vue").default,
    },
];

const router = new VueRouter({
    routes, // short for `routes: routes`
});
