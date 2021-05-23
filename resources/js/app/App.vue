<template lang="">
    <div>
        <nav class="navbar navbar-dark bg-dark">
            <div class='logout' v-if="this.$store.state.token !== ''">
                <div class="search-container">
                  <form class="form-inline my-2 my-lg-0">
                          <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" v-model="searchTerm">
                          <button class="btn btn-outline-success my-2 my-sm-0" @click.prevent="search">Search</button>
                    </form>
                </div>
                <div class="action-buttons">
                  <button class="btn btn-info mr-3" @click="navigateToAddItem">Add Item</button>
                  <button class="btn btn-danger" @click="logout">Logout</button>
                </div>
            </div>
            <div class='register' v-if="this.$store.state.token === ''">
                <div v-if="this.$store.state.currentRoute === 'Login'">
                    <button class="btn btn-warning" @click="navigateToRegister">REGISTER</button>
                </div>
                <div v-if="this.$store.state.currentRoute === 'Register'">
                    <button class="btn btn-warning" @click="navigateToLogin">LOGIN</button>
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
  mounted() {
    if (this.$store.state.token !== "") {
      axios
        .post("/api/checktoken", { token: this.$store.state.token })
        .then((res) => {
          if (res.data.success) {
            this.$router
              .push("/dashboard")
              .catch((err) => console.log("ROUTER ERROR", err));
          }
        })
        .catch((err) => {
          this.$store.commit("clearToken");
          this.$router
            .push("/login")
            .catch((err) => console.log("ROUTER ERROR", err));
        });
    } else {
      this.$store.commit("clearToken");
      this.$router.push("/login");
    }
  },
  methods: {
    logout() {
      axios
        .post("/api/logout", { token: this.$store.state.token })
        .then((res) => {
          if (res.data.success) {
            this.$store.commit("clearToken");
            this.$router
              .push("/login")
              .catch((err) => console.log("ROUTER ERROR", err));
          }
        })
        .catch((err) => console.log("LOGOUT ERROR", err));
    },
    navigateToAddItem() {
      this.$router.push("/add");
    },
    navigateToRegister() {
      this.$router.push("/register");
    },
    navigateToLogin() {
      this.$router.push("/login");
    },
    search() {
      console.log("SEARCH", this.searchTerm);
      this.$emit("refetch", 1, this.searchTerm);
    },
  },
};
</script>
<style scoped>
.navbar {
  /* justify-content: flex-end; */
  height: 70px;
}

.navbar div {
  padding: 1px 20px;
  margin: 5px 5px;
}

.logout {
  /* align-self: flex-end; */
  display: flex;
  flex-direction: row;
  width: 100%;
}

.register {
  align-self: flex-end;
}

.links {
  display: flex;
  align-self: flex-start;
}
.search-container {
  width: 50%;
}

.action-buttons {
  display: flex;
  width: 50%;
  justify-content: flex-end;
}
</style>