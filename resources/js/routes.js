import UserLayout from "./layouts/UserLayout"
import MenuUser from "./components/user/MenuUserComponent"
import Home from "./components/user/HomeComponent"
import Cart from "./components/user/CartComponent"
import Order from "./components/user/OrderComponent"
import Transaction from "./components/user/TransactionComponent"
import Contact from "./components/user/ContactComponent"
import ProfileComponent from "./components/ProfileComponent"

const routes = [,
    {
        path: '/',
        component: UserLayout,
        children: [
            {
                path: '/',
                component: Home,
            },{
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
    { path: '/:catchAll(.*)', redirect: '/' },
];

export default routes;