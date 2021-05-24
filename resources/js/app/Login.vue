<template>
  <div>
    <loading v-if="loading"></loading>
    <div class="login" v-else>
      <h2>Login</h2>
      <span class="text-danger" v-if="this.error.length > 0">{{
        this.error[0]
      }}</span>
      <div
        class="alert alert-success alert-dismissible fade show"
        role="alert"
        v-if="this.$route.params.registrationSuccess"
      >
        {{ this.$route.params.message }}
        <button
          type="button"
          class="close"
          data-dismiss="alert"
          aria-label="Close"
        >
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form">
        <div class="form-group">
          <input
            class="form-control"
            placeholder="Email"
            v-model="credentials.email"
          />
          <span
            class="text-danger"
            v-if="
              (!$v.credentials.email.required || !$v.credentials.email.email) &&
              $v.credentials.email.$dirty
            "
            >Valid email is required</span
          >
        </div>
        <div class="form-group">
          <input
            class="form-control"
            placeholder="Password"
            type="password"
            v-model="credentials.password"
          />
          <span
            class="text-danger"
            v-if="
              !$v.credentials.password.required &&
              $v.credentials.password.$dirty
            "
            >Password is required</span
          >
        </div>
        <button class="btn btn-primary btn-block" @click.prevent="login">
          LOGIN
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import API_URL from "./config";
import { required, email } from "vuelidate/lib/validators";
import Loading from "./Loading";
export default {
  name: "Login",
  components: {
    Loading,
  },
  data: () => {
    return {
      credentials: {
        email: "",
        password: "",
      },
      loading: true,
      error: [],
    };
  },
  validations: {
    credentials: {
      email: {
        required,
        email,
      },
      password: {
        required,
      },
    },
  },
  mounted() {
    this.$store.commit("setCurrentRoute", this.$router.currentRoute.name);
    if (this.$store.state.token !== "") {
      const endpoint = `${API_URL}/checktoken`;
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
          // this.$router.push("/");
          this.$store.commit("clearToken");
        });
    } else {
      this.loading = false;
      // this.$router.push("/");
    }
  },
  methods: {
    login() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        const endpoint = `${API_URL}/login`;
        axios
          .post(endpoint, this.credentials)
          .then((res) => {
            if (res.data.success) {
              // Update the store
              this.$store.commit("setToken", res.data.user.token);
              this.$router
                .push("/dashboard")
                .catch((err) => console.log("ROUTER ERROR", err));
            }
          })
          .catch((err) => {
            const { success, error, message } = err.response.data;
            if (!success) {
              if (message) {
                this.error = [];
                this.error.push(message);
              } else {
                this.error = [];
                this.error.push(error[0]);
              }
            }
          });
      }
    },
  },
};
</script>

<style scoped>
.login {
  background-color: #fff;
  border: 1px solid #eee;
  padding: 10px;
  margin: 50px auto;
  width: 40%;
  height: 70%;
}

.login h2 {
  margin-bottom: 20px;
}
</style>