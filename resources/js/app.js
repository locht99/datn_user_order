require("./bootstrap");
require("flowbite");
import { error } from "laravel-mix/src/Log";
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import App from "./App.vue";
import { getUser } from "./config/user";
import routes from "./routes";

const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    let token = localStorage.getItem("token");
    if (token) {
        getUser()
            .then((res) => {
                if (res.data) {
                    if (to.matched.some((record) => record.meta.requiresAuth)) {
                        next()
                    }else if (to.matched.some((record) => record.meta.notLogin)) {
                        router.replace("/")
                    }else{
                        next()
                    }
                }
            })
            .catch((error) => {
                if (to.matched.some((record) => record.meta.notLogin)) {
                    next()
                }else if (to.matched.some((record) => record.meta.requiresAuth)) {
                    router.replace("/login")
                }else{
                    next()
                }
            });
    } else {
        router.replace("/login");
    }
});

const app = createApp(App);
app.use(router);
app.mount("#app");
