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
    faCheckSquare,
    faBars,
    faHome,
    faCheckCircle,
    faTimesCircle,
    faHandPaper
} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";
import Vuelidate from "vuelidate";
import VueObserveVisibility from "vue-observe-visibility";

// Modules
Vue.use(VueObserveVisibility);
Vue.use(Vuelidate);

// Icons
library.add(
    faPlusSquare,
    faTrash,
    faEdit,
    faPenSquare,
    faCheckSquare,
    faBars,
    faHome,
    faCheckCircle,
    faTimesCircle,
    faHandPaper
);

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
