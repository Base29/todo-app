<template lang="">
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <div class='action-btn-container' v-if="this.$store.state.token !== ''">
                <div class="search-container">
                  <form class="form-inline my-2 my-lg-0">
                          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" v-model="searchTerm">
                          <button class="btn btn-outline-success my-2 my-sm-0" @click.prevent="search">Search</button>
                          <button type="button" class="btn btn-outline-danger my-2 my-sm-0 ml-2" @click.prevent="clearSearch" :disabled="searchTerm === ''">Clear</button>
                    </form>
                </div>
                <div class="action-buttons">
                  <button class="btn btn-info mr-3" @click="navigateToAddItem">Add Item</button>
                  <button class="btn btn-danger" @click="logout">Logout</button>
                </div>
            </div>
            <div class='register' v-if="this.$store.state.token === ''">
              <div class="home-container" v-if="this.$store.state.currentRoute === 'Login' || this.$store.state.currentRoute === 'Register' || this.$store.state.currentRoute === 'VerifyEmail'">
                <button class="home" @click="navigateToWelcome">
                  <font-awesome-icon icon="home" />
                </button>
              </div>
              <div class="auth-button-container">
                <div v-if="this.$store.state.currentRoute === 'Login'">
                    <button class="btn btn-warning" @click="navigateToRegister">REGISTER</button>
                </div>
                <div v-if="this.$store.state.currentRoute === 'Register'">
                    <button class="btn btn-warning" @click="navigateToLogin">LOGIN</button>
                </div>
              </div>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
import axios from "axios";
export default {
  name: "App",
  data() {
    return {
      searchTerm: "",
    };
  },
  methods: {
    // Logout API call
    logout() {
      axios
        .post("/api/logout", { token: this.$store.state.token })
        .then((res) => {
          if (res.data.success) {
            this.$store.commit("clearToken");
            this.$router
              .push("/")
              .catch((err) => console.log("ROUTER ERROR", err));
          }
        })
        .catch((err) => console.log("LOGOUT ERROR", err));
    },
    // Navigating to Add Item screen
    navigateToAddItem() {
      this.$router.push("/add");
    },
    // Navigating to Register screen
    navigateToRegister() {
      this.$router.push("/register");
    },
    // Navigating to Login screen
    navigateToLogin() {
      this.$router.push("/login");
    },
    // Method responsible for search
    search() {
      this.$root.$refs.Dashboard.getList(1, this.searchTerm, true);
    },
    // Clearing search input field
    clearSearch() {
      this.searchTerm = "";
      this.$root.$refs.Dashboard.getList(1, this.searchTerm, true);
    },
    // Navigating to Welcome screen
    navigateToWelcome() {
      this.$router.push("/");
    },
  },
};
</script>
<style scoped>
.navbar {
  height: 70px;
}

.navbar div {
  padding: 2px 20px;
  margin: 1px 5px;
}

.action-btn-container {
  display: flex;
  flex-direction: row;
  width: 100%;
}

.register {
  display: flex;
  width: 100%;
}

.search-container {
  width: 50%;
}

.action-buttons {
  display: flex;
  width: 50%;
  justify-content: flex-end;
}

.home-container {
  width: 30%;
}

.auth-button-container {
  display: flex;
  width: 70%;
  justify-content: flex-end;
}

.home {
  background: none;
  border: none;
  color: #ffffff;
  outline: none;
  font-size: 25px;
}
</style>