import Vue from "vue";
import VueRouter from "vue-router";
import Login from "./Login";
import Dashboard from "./Dashboard";
import Register from "./Register";
import EditItem from "./EditItem";
import AddItem from "./AddItem";
import Welcome from "./Welcome";
import VerifyEmail from "./VerifyEmail.vue";

Vue.use(VueRouter);

export const routes = [
    {
        path: "/",
        component: Welcome,
        name: "Welcome"
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
    },
    {
        path: "/edit/:itemId",
        name: "Edit",
        component: EditItem
    },
    {
        path: "/add",
        name: "Add",
        component: AddItem
    },
    {
        path: "/verify-email",
        name: "VerifyEmail",
        component: VerifyEmail
    }
];
