require("./bootstrap");
import Vue from "vue";
import App from "./app/App";
import { routes } from "./app/routes";
import VueRouter from "vue-router";
import { store } from "./app/store";
import { library } from "@fortawesome/fontawesome-svg-core";
import {
    faPlusSquare,
    faTrash,
    faPenSquare,
    faEdit
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

library.add(faPlusSquare, faTrash, faEdit, faPenSquare);

Vue.component("font-awesome-icon", FontAwesomeIcon);

const router = new VueRouter({
    routes,
    mode: "history"
});

const app = new Vue({
    el: "#app",
    router: router,
    store: store,
    render: app => app(App)
});
