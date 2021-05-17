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
      <!-- <div class="chkBox">
        <input
          type="checkbox"
          @change="updateCheck()"
          v-model="item.completed"
        />
      </div> -->
      <div class="edit-btn">
        <button class="editpen">
          <font-awesome-icon icon="pen-square" />
        </button>
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
}

.item-container {
  display: flex;
  flex-direction: row;
  margin: 0 0 20px 0;
  background-color: #fff;
  padding: 10px;
}

/* .item-container div {
  display: inline-block;
  font-size: 20px;
  background-color: #fff;
} */

.item-data {
  width: 80%;
}

.action-container {
  display: flex;
  justify-content: flex-end;
  width: 20%;
  background-color: aqua;
  align-items: center;
}

/* .del-btn {
  float: right;
}

.edit {
  float: right;
} */

.trashcan {
  background: none;
  border: none;
  color: red;
  outline: none;
  font-size: 20px;
}

.editpen {
  background: none;
  border: none;
  color: blue;
  outline: none;
  font-size: 20px;
}
</style>