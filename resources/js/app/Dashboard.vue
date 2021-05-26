<template>
  <div ref="dashboard">
    <loading v-if="loading"></loading>
    <div v-else>
      <div v-if="this.items.length > 0">
        <list-view :items="items" @refetch="getList" />
      </div>
      <div class="no-items" v-else>
        <h2>No Items</h2>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import ListView from "./ListView";
import API_URL from "./config";
import Loading from "./Loading";
export default {
  name: "Dashboard",
  components: {
    ListView,
    Loading,
  },
  data() {
    return {
      loading: true,
      items: [],
      lastPage: 1,
    };
  },
  mounted() {
    // Checking if the user has a valid JWT token
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
          this.$router.push("/");
        });
    } else {
      this.$router.push("/");
      this.loading = false;
    }
  },
  methods: {
    // Fetching Todo Items
    async getList(page, query, isReset) {
      if (page > this.lastPage) {
        return;
      }

      const searchParam = query === undefined ? "" : query;
      const endpoint = `${API_URL}/items?page=${page}&q=${searchParam}`;

      // Checking if isReset is not undefined
      if (isReset !== undefined) {
        this.items = [];
      }
      await axios
        .get(endpoint, {
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            const { items } = response.data;

            // Pushing items to array
            this.items.push(...items.data);

            // Setting last page
            this.lastPage = items.last_page;
          }
        })
        .catch((err) => console.log("error", err));
    },
  },
  created() {
    this.getList(1);

    // Defining Ref
    this.$root.$refs.Dashboard = this;
  },
};
</script>

<style>
.no-items {
  display: flex;
  justify-content: center;
  margin: 30px 0 0 0;
}
</style>