import UserLayout from "./layouts/UserLayout"
import MenuUser from "./components/user/MenuUserComponent"
import Home from "./components/user/HomeComponent"
import Cart from "./components/user/CartComponent"
import Order from "./components/user/OrderComponent"
import Transaction from "./components/user/TransactionComponent"
import Contact from "./components/user/ContactComponent"
import ProfileComponent from "./components/ProfileComponent"
import LoginComponent from "./components/auth/LoginComponent"
import RegisterComponent from "./components/auth/RegisterComponent"

const routes = [,
    {
        path: '/',
        component: UserLayout,
        children: [{
                path: '/',
                component: Home,
            }, {
                path: '/cart',
                component: Cart,
            },
            {
                path: '/order',
                component: Order
            },
            {
                path: '/transaction',
                component: Transaction
            },
            {
                path: '/contact',
                component: Contact
            },
        ]
    },
    {
        path: '/profile',
        component: ProfileComponent
    },
    {
        path: '/login',
        component: LoginComponent
    },
    {
        path: '/register',
        component: RegisterComponent
    },
    { path: '/:catchAll(.*)', redirect: '/' },
];

export default routes;