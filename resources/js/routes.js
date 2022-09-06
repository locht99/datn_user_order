import UserLayout from "./layouts/UserLayout"
import MenuUser from "./components/user/MenuUserComponent"
import Home from "./components/user/HomeComponent"
import Cart from "./components/user/CartComponent"
import Order from "./components/user/OrderComponent"
import Transaction from "./components/user/TransactionComponent"
import Contact from "./components/user/ContactComponent"
import Signup from "./components/auth/SignupComponent"
import Signin from "./components/auth/SigninComponent"


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

    { path: '/signin', component: Signin },

    { path: '/signup', component: Signup },

    { path: '/:catchAll(.*)', redirect: '/' },
];

export default routes;