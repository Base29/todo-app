<template lang="">
    <div class="container">
        <div v-for="(item, index) in items" :key="index">
            <list-item :item="item" v-on:itemchanged="$emit('reloadlist')" />
        </div>
    </div>
</template>
<script>
import ListItem from "./listItem";
export default {
  name: "ListView",
  props: ["items"],
  components: {
    ListItem,
  },
};
</script>
<style>
.container {
  background-color: #ececec;
  min-height: 200px;
  padding-top: 20px;
}
</style>