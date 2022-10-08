require("./bootstrap");
require("flowbite");
import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import App from "./App.vue";
import { getUser } from "./config/user";
import routes from "./routes";
import VueTailwindPagination from "@ocrv/vue-tailwind-pagination";
const router = createRouter({
    history: createWebHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    let token = localStorage.getItem("token") || null;
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
            next();
        });
});

const app = createApp(App);
app.component("VueTaildwindPagination", VueTailwindPagination);
app.use(router);
app.mount("#app");
