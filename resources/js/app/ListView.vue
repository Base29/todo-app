<template lang="">
    <div class="container">
        <div v-for="(item, index) in items" :key="index">
            <list-item :item="item" class="item" v-on:itemchanged="$emit('reloadlist')" />
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
/* .item {
        background: #e6e6e6;
        padding: 5px;
        margin-top: 5px;
    } */
.container {
  margin-right: 0;
}
</style>