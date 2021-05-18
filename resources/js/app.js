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
    faEdit,
    faCheckSquare
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Vuelidate from "vuelidate";
Vue.use(Vuelidate);

library.add(faPlusSquare, faTrash, faEdit, faPenSquare, faCheckSquare);

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
