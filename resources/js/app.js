require("./bootstrap");
require("flowbite");
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import App from "./App.vue";
import { getUser } from "./config/user";
import routes from "./routes";
import Pagination from "./helpers/pagination.vue";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    let token = localStorage.getItem("token") || null;
    if (token) {
        getUser()
            .then((res) => {
                if (res.data) {
                    if (to.matched.some((record) => record.meta.requiresAuth)) {
                        next();
                    } else if (to.matched.some((record) => record.meta.notLogin)) {
                        router.replace("/");
                    } else {
                        next();
                    }
                }
            })
            .catch((error) => {
                if (to.matched.some((record) => record.meta.notLogin)) {
                    next();
                } else if (to.matched.some((record) => record.meta.requiresAuth)) {
                    router.replace("/login");
                } else {
                    next();
                }
            });
    }else{
        if (to.matched.some((record) => record.meta.requiresAuth)) {
            router.replace("/login");
        } else if (to.matched.some((record) => record.meta.notLogin)) {
            next()
        }
    }
});

const app = createApp(App);
app.component("Pagination", Pagination);
app.use(router);
app.use(VueSweetalert2);

app.mount("#app");
