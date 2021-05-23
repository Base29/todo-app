<template lang="">
    <div class="container">
        <div v-for="(item, index) in items" :key="index">
            <list-item :item="item" v-on:itemchanged="$emit('refetch', 1, '')" />
        </div>
        <div v-if="items.length" v-observe-visibility="handleInfiniteScroll"></div>
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
  data() {
    return {
      page: 1,
    };
  },
  methods: {
    handleInfiniteScroll(isVisible) {
      if (!isVisible) {
        return;
      }
      this.page++;
      this.$emit("refetch", this.page);
    },
  },
};
</script>
<style>
.container {
  background-color: #ececec;
  min-height: 200px;
  padding-top: 20px;
  padding-bottom: 20px;
}
</style>