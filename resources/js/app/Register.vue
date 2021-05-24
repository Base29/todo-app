<template>
  <div>
    <loading v-if="loading"></loading>
    <div class="register" v-else>
      <h2>Register</h2>
      <span class="text-danger" v-if="this.error.length > 0">{{
        this.error[0]
      }}</span>
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
        <div class="form-group">
          <input
            class="form-control"
            placeholder="Confirm Password"
            type="password"
            v-model="credentials.password_confirmation"
          />
          <span
            class="text-danger"
            v-if="
              !$v.credentials.password_confirmation.required &&
              $v.credentials.password_confirmation.$dirty
            "
            >Password Confirmation is required</span
          >
          <span
            class="text-danger"
            v-if="!$v.credentials.password_confirmation.sameAsPassword"
            >Password do not match</span
          >
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
import { required, email, sameAs } from "vuelidate/lib/validators";
import Loading from "./Loading";
export default {
  name: "Register",
  components: {
    Loading,
  },
  data: () => {
    return {
      credentials: {
        email: "",
        password: "",
        password_confirmation: "",
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
      password_confirmation: {
        required,
        sameAsPassword: sameAs("password"),
      },
    },
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
      this.$v.$touch();
      if (!this.$v.$invalid) {
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
          .catch((err) => {
            const { success, error } = err.response.data;
            if (!success) {
              this.error.push(error[0]);
            }
          });
      }
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