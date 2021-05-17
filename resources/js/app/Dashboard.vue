<template>
  <div>
    <div v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div v-else>
      <list-view :items="items" v-on:reloadlist="getList()" />
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ListView from "./ListView";
import API_URL from "./config";
export default {
  name: "Dashboard",
  components: {
    ListView,
  },
  data() {
    return {
      loading: true,
      items: [],
    };
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
    getList() {
      const endpoint = `${API_URL}/items`;
      axios
        .get(endpoint, {
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            this.items = response.data.items;
          }
        })
        .catch((error) => console.log("error".error));
    },
  },
  created() {
    this.getList();
  },
};
</script>

<style>
</style>