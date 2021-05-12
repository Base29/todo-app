import Vuex from "vuex";
import Vue from "vue";

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        token: localStorage.getItem("token") || "",
        currentRoute: ""
    },
    mutations: {
        setToken(state, token) {
            localStorage.setItem("token", token);
            state.token = token;
        },

        clearToken(state) {
            localStorage.removeItem("token");
            state.token = "";
        },

        setCurrentRoute(state, routeName) {
            state.currentRoute = routeName;
        }
    }
});
