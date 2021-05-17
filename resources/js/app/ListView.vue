<template lang="">
    <div class="container">
        <div v-for="(item, index) in items" :key="index">
            <list-item :item="item" v-on:itemchanged="$emit('reloadlist')" />
        </div>
    </div>
</template>
<script>
import ListItem from "./listItem";
import API_URL from "./config";
export default {
  name: "ListView",
  props: ["items"],
  components: {
    ListItem,
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
};
</script>
<style>
.container {
  background-color: #ececec;
  min-height: 200px;
  padding-top: 20px;
  padding-bottom: 10px;
}
</style>