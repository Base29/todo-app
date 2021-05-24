<template>
  <div class="item-container">
    <div class="item-data">
      <span class="label">Title: </span>
      <span :class="[this.item.completed ? 'completed' : '', 'itemText']">{{
        item.title
      }}</span>
      <br />
      <span class="label">Description: </span>
      <span :class="[this.item.completed ? 'completed' : '', 'itemText']">{{
        item.description
      }}</span>
    </div>
    <div class="action-container">
      <div class="edit-btn">
        <button @click="editItem" class="editmenu">
          <font-awesome-icon icon="bars" />
        </button>
      </div>
    </div>
  </div>
</template>
<script>
import API_URL from "./config";
export default {
  name: "ListItem",
  props: ["item"],
  data() {
    return {
      done: this.item.completed,
    };
  },
  computed: {
    isDisabled: function () {
      return !!this.item.completed;
    },
  },
  methods: {
    editItem() {
      const itemId = this.item.id;
      const isCompleted = this.item.completed;
      this.$router.push({ name: "Edit", params: { itemId, isCompleted } });
    },
  },
};
</script>
<style scoped>
.completed {
  text-decoration: line-through;
  color: #999999;
}

.itemText {
  width: 100%;
}

.item-container {
  display: flex;
  flex-direction: row;
  margin: 0 0 20px 0;
  background-color: #fff;
  padding: 10px;
}

.item-data {
  width: 80%;
}

.action-container {
  display: flex;
  justify-content: flex-end;
  width: 20%;
  align-items: center;
}

.editmenu {
  background: none;
  border: none;
  color: #292828;
  outline: none;
  font-size: 20px;
}

.label {
  font-weight: bold;
}
</style>