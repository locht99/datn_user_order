import UserLayout from "./layouts/UserLayout";
import MenuUser from "./components/user/MenuUserComponent";
import Home from "./components/user/HomeComponent";
import Cart from "./components/user/CartComponent";
import Order from "./components/user/OrderComponent";
import OrderDetail from "./components/user/OrderDetailComponent"
import Transaction from "./components/user/TransactionComponent";
import Contact from "./components/user/ContactComponent";
import ProfileComponent from "./components/ProfileComponent";
import LoginComponent from "./components/auth/LoginComponent";
import RegisterComponent from "./components/auth/RegisterComponent";
import CreateTransaction from './components/user/Transaction/CreateTransactionComponent.vue';
import NewAddressComponent from "./components/user/NewAddressComponent"
import FeeService from "./components/user/FeeServiceComponent.vue"
import ForgotPasswordComponent from "./components/user/ForgotPasswordComponent"
import ResetPasswordComponent from "./components/user/ResetPasswordComponent"
const routes = [
    {
        path: "/",
        component: UserLayout,
        meta: { requiresAuth: true },
        children: [{
                path: "/",
                component: Home,
                title: 'Homehh'
            },
            {
                path: "/cart",
                component: Cart,
            },
            {
                path: "/order",
                component: Order,
            },
            {
                path: "/order-detail/:id",
                component: OrderDetail,
            },
            {
                path: "/transaction",
                component: Transaction,
            },
            {
                path: "/transaction/create",
                component: CreateTransaction
            },
            {
                path: "/contact",
                component: Contact,
            },
            {
                path: "/fee",
                component: FeeService,
            },
        ],
    },
    {
        path: "/user/profile",
        meta: { requiresAuth: true },
        component: ProfileComponent,
    },
    {
        path: "/user/new-address",
        meta: { requiresAuth: true },
        component: NewAddressComponent,
    },
    {
        path: "/user/forgot-password",
        meta: { notLogin: true },
        component: ForgotPasswordComponent,
    },
    {
        path: "/user/reset-password",
        meta: { notLogin: true },
        component: ResetPasswordComponent,
    },
    {
        path: "/login",
        component: LoginComponent,
        meta: { notLogin: true }
    },
    {
        path: "/register",
        component: RegisterComponent,
        meta: { notLogin: true }
    },
    { path: "/:catchAll(.*)", redirect: "/" },
];

export default routes;