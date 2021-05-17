import Vue from "vue";
import VueRouter from "vue-router";
import Login from "./Login";
import Dashboard from "./Dashboard";
import Register from "./Register";
import EditItem from "./EditItem";
import AddItem from "./AddItem";

Vue.use(VueRouter);

export const routes = [
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
    }
];
