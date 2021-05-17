<template>
  <div>
    <div v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="register" v-else>
      <h2>Register</h2>
      <form class="form">
        <div class="form-group">
          <input
            class="form-control"
            placeholder="Email"
            v-model="credentials.email"
          />
        </div>
        <div class="form-group">
          <input
            class="form-control"
            placeholder="Password"
            type="password"
            v-model="credentials.password"
          />
        </div>
        <div class="form-group">
          <input
            class="form-control"
            placeholder="Confirm Password"
            type="password"
            v-model="credentials.password_confirmation"
          />
        </div>
        <button class="btn btn-primary btn-block" @click.prevent="register">
          REGISTER
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import API_URL from "./config";
export default {
  name: "Register",
  data() {
    return {
      credentials: {
        email: "",
        password: "",
        password_confirmation: "",
      },
      loading: true,
    };
  },
  mounted() {
    this.$store.commit("setCurrentRoute", this.$router.currentRoute.name);
    const endpoint = `${API_URL}/checktoken`;
    if (this.$store.state.token !== "") {
      axios
        .post(endpoint, { token: this.$store.state.token })
        .then((res) => {
          if (res.data.success) {
            this.loading = false;
            this.$router.push("/dashboard");
          }
        })
        .catch((err) => {
          console.log("TOKEN VALIDATION ERROR", err);
          this.loading = false;
          this.$store.commit("clearToken");
        });
    } else {
      this.loading = false;
    }
  },
  methods: {
    register() {
      const endpoint = `${API_URL}/register`;
      axios
        .post(endpoint, this.credentials)
        .then((res) => {
          if (res.data.success) {
            this.$router
              .push("/login")
              .catch((err) => console.log("ROUTER ERROR", err));
          }
        })
        .catch((err) => console.log("REGISTER ERROR", err));
    },
  },
};
</script>

<style scoped>
.register {
  background-color: #fff;
  border: 1px solid #eee;
  padding: 10px;
  margin: 50px auto;
  width: 40%;
  height: 70%;
}

.register h2 {
  margin-bottom: 20px;
}
</style>