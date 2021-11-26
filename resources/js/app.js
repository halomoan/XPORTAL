/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue").default;

import Form from "vform";
window.Form = Form;
import { HasError, AlertError } from "vform/src/components/bootstrap5";

Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);

import Role from "./Role";
Vue.prototype.$Role = new Role(window.user);

import VueRouter from "vue-router";

Vue.use(VueRouter);

const routes = [
    {
        path: "/manage/users",
        component: require("./components/Users/Users.vue").default,
    },
    {
        path: "/manage/userd",
        component: require("./components/Users/UserDetail.vue").default,
    },
    {
        path: "/manage/roles",
        component: require("./components/Roles/Roles.vue").default,
    },
];

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: "history",
});

Vue.component("pagination", require("vue-pagination-2"));

import VueProgressBar from "vue-progressbar";
Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "2px",
});

import moment from "moment";
Vue.filter("humanDate", function (date) {
    return moment(date).format("MMM Do YYYY");
});
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component(
//     "example-component",
//     require("./components/ExampleComponent.vue").default
// );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Vue from "vue";

import Swal from "sweetalert2";
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    },
});

window.Toast = Toast;

const Fire = new Vue();
window.Fire = Fire;

const app = new Vue({
    el: "#app",
    router,
    methods: {
        logout() {
            Swal.fire({
                title: "Logout",
                text: "Are you sure?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Logout",
            }).then((result) => {
                if (result.value === true) {
                    axios
                        .post("/logout")
                        .then((response) => {
                            localStorage.removeItem("auth_token");
                            localStorage.removeItem("expiration");
                            delete axios.defaults.headers.common[
                                "Authorization"
                            ];
                            this.$router.go("/login");
                        })
                        .catch((error) => {
                            localStorage.removeItem("auth_token");
                            localStorage.removeItem("expiration");
                            delete axios.defaults.headers.common[
                                "Authorization"
                            ];
                            this.$router.go("/login");
                        });
                }
            });
        },
    },
});
