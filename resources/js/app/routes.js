import Vue from "vue";
import VueRouter from "vue-router";
import Home from "./Home";
import Login from "./Login";
import Dashboard from "./Dashboard";
import Register from "./Register";

Vue.use(VueRouter);

export const routes = [
    {
        path: "/",
        component: Home,
        name: "Home"
    },
    {
        path: "/login",
        component: Login,
        name: "Login"
    },
    {
        path: "/dashboard",
        component: Dashboard,
        name: "Dashboard"
    },
    {
        path: "/register",
        component: Register,
        name: "Register"
    }
];
