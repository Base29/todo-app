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
    // Setting current route name
    this.$store.commit("setCurrentRoute", this.$router.currentRoute.name);
  },
  methods: {
    // Navigating to Login screen
    navigateToLogin() {
      this.$router.push("/login");
    },
    // Navigating to Register screen
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