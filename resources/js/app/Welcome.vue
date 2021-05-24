<template>
  <div class="container">
    <div class="d-flex justify-content-center mb-5">
      <h1>Welcome to Todo List</h1>
    </div>
    <div class="d-flex justify-content-center">
      <button class="btn btn-warning button mr-3" @click="navigateToRegister">
        REGISTER
      </button>
      <button class="btn btn-primary button" @click="navigateToLogin">
        LOGIN
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: "Welcome",
  mounted() {
    this.$store.commit("setCurrentRoute", this.$router.currentRoute.name);
    // if (this.$store.state.token !== "") {
    //   axios
    //     .post("/api/checktoken", { token: this.$store.state.token })
    //     .then((res) => {
    //       if (res.data.success) {
    //         this.$router
    //           .push("/dashboard")
    //           .catch((err) => console.log("ROUTER ERROR", err));
    //       }
    //     })
    //     .catch((err) => {
    //       this.$store.commit("clearToken");
    //       this.$router
    //         .push("/")
    //         .catch((err) => console.log("ROUTER ERROR", err));
    //     });
    // } else {
    //   this.$store.commit("clearToken");
    //   this.$router.push("/");
    // }
  },
  methods: {
    navigateToLogin() {
      this.$router.push("/login");
    },
    navigateToRegister() {
      this.$router.push("/register");
    },
  },
};
</script>

<style>
.button {
  width: 25%;
}
</style>