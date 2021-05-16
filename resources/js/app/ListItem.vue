<template>
  <div class="item-container">
    <div class="item-data">
      <span :class="[item.completed ? 'completed' : '', 'itemText']">{{
        item.title
      }}</span>
      <br />
      <span :class="[item.completed ? 'completed' : '', 'itemText']">{{
        item.description
      }}</span>
    </div>
    <div class="action-container">
      <div class="chkBox">
        <input
          type="checkbox"
          @change="updateCheck()"
          v-model="item.completed"
        />
      </div>
      <div class="del-btn">
        <button @click="removeItem()" class="trashcan">
          <font-awesome-icon icon="trash" />
        </button>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "ListItem",
  props: ["item"],
  methods: {
    updateCheck() {
      axios
        .put("api/item/" + this.item.id, {
          item: this.item,
        })
        .then((response) => {
          if (response.status === 200) {
            this.$emit("itemchanged");
          }
        })
        .catch((error) => {
          console.log("error".error);
        });
    },

    removeItem() {
      console.log("ITEM", this.item.id);
      axios
        .delete("api/item/" + this.item.id)
        .then((response) => {
          if (response.status === 200) {
            this.$emit("itemchanged");
          }
        })
        .catch((error) => console.log("error".error));
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
  margin-left: 20px;
}

.item-container {
  width: 50%;
  margin: 20px 0 20px 0;
  /* padding: 0; */
}

.item-container div {
  display: inline-block;
  font-size: 20px;
}

.item-data {
  width: 80%;
  background-color: aqua;
}

.action-container {
  background-color: brown;
  float: right;
  width: 20%;
  justify-content: end;
}

.del-btn {
  background-color: blue;
}

.trashcan {
  background: #e6e6e6;
  border: none;
  color: red;
  outline: none;
  align-self: flex-end;
}
</style>