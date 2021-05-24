<template>
  <div>
    <div v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="add-item" v-else>
      <h2>Add Item</h2>
      <form class="form">
        <div class="form-group">
          <label for="title">Title</label>
          <input class="form-control" v-model="title" />
          <span class="text-danger" v-if="!$v.title.required && $v.title.$dirty"
            >Title is required</span
          >
        </div>
        <div class="form-group">
          <label for="title">Description</label>
          <input class="form-control" v-model="description" />
          <span
            class="text-danger"
            v-if="!$v.description.required && $v.description.$dirty"
            >Description is required</span
          >
        </div>
        <button class="btn btn-primary btn-block" @click.prevent="add">
          ADD
        </button>
        <button
          class="btn btn-secondary btn-block"
          @click.prevent="backToDashboard"
        >
          CANCEL
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import API_URL from "./config";
import { required } from "vuelidate/lib/validators";
export default {
  name: "AddItem",
  data() {
    return {
      title: "",
      description: "",
      loading: true,
    };
  },
  validations: {
    title: {
      required,
    },
    description: {
      required,
    },
  },
  mounted() {
    if (this.$store.state.token !== "") {
      const endpoint = `${API_URL}/checktoken`;
      axios
        .post(endpoint, { token: this.$store.state.token })
        .then((res) => {
          this.loading = false;
        })
        .catch((err) => {
          console.log("ERR TOKEN VERIFICATION", err);
          this.loading = false;
          this.$store.commit("clearToken");
          this.$router.push("/login");
        });
    } else {
      this.$router.push("/login");
      this.loading = false;
    }
  },
  methods: {
    add() {
      this.$v.$touch();
      if (!this.$v.$invalid) {
        const endpoint = `${API_URL}/item`;
        const data = {
          title: this.title,
          description: this.description,
        };
        const header = {
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        };
        axios
          .post(endpoint, data, header)
          .then((response) => {
            if (response.data.success) {
              this.$router.push("/dashboard");
            }
          })
          .catch((err) => console.log("ADD ERROR", err));
      }
    },
    backToDashboard() {
      this.$router.back();
    },
  },
};
</script>

<style>
.add-item {
  background-color: #fff;
  border: 1px solid #eee;
  padding: 10px;
  margin: 50px auto;
  width: 40%;
  height: 70%;
}

.add-item h2 {
  margin-bottom: 20px;
}
</style>