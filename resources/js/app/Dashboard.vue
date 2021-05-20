<template>
  <div>
    <loading v-if="loading"></loading>
    <div v-else>
      <div v-if="this.items.length > 0">
        <list-view
          :items="items"
          v-on:reloadlist="getList()"
          @refetch="getList"
        />
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
    async getList(page, query) {
      if (page > this.lastPage) {
        return;
      }
      console.log("PAGE", page);
      console.log("LAST PAGE", this.lastPage);

      const endpoint = `${API_URL}/items?page=${page}&q=${query}`;
      await axios
        .get(endpoint, {
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        })
        .then((response) => {
          console.log("response", response);
          if (response.data.success) {
            const { items } = response.data;
            this.items.push(...items.data);
            this.lastPage = items.last_page;
          }
        })
        .catch((error) => console.log("error".error));
    },
  },
  created() {
    this.getList(1);
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