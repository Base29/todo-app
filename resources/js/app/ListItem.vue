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
      <div class="done-btn">
        <button
          :class="[this.item.completed ? 'chkBox-done' : 'chkBox']"
          @click="markDone()"
          :disabled="isDisabled"
        >
          <font-awesome-icon icon="check-square" />
        </button>
      </div>
      <div class="edit-btn">
        <button
          :class="this.item.completed ? 'editpen-disabled' : 'editpen'"
          @click="editItem()"
          :disabled="isDisabled"
        >
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
    markDone() {
      this.done = !this.item.completed;
      const itemId = this.item.id;
      const endpoint = `${API_URL}/done/${itemId}`;
      const header = {
        headers: {
          Authorization: `Bearer ${this.$store.state.token}`,
        },
      };
      const data = {
        done: !this.item.completed,
      };
      axios
        .put(endpoint, data, header)
        .then((response) => {
          if (response.status === 200) {
            console.log("response", response.data);
            this.$emit("itemchanged");
          }
        })
        .catch((error) => {
          console.log("error".error);
        });
    },

    removeItem() {
      const itemId = this.item.id;
      const endpoint = `${API_URL}/item/${itemId}`;
      const header = {
        headers: {
          Authorization: `Bearer ${this.$store.state.token}`,
        },
      };
      axios
        .delete(endpoint, header)
        .then((response) => {
          if (response.status === 200) {
            this.$emit("itemchanged");
          }
        })
        .catch((error) => console.log("error".error));
    },
    editItem() {
      console.log("EDIT ITEM", this.item.id);
      const itemId = this.item.id;
      this.$router.push({ name: "Edit", params: { itemId } });
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

.editpen-disabled {
  background: none;
  border: none;
  color: #999999;
  outline: none;
  font-size: 20px;
}

.chkBox {
  background: none;
  border: none;
  color: #999999;
  outline: none;
  font-size: 20px;
}

.chkBox-done {
  background: none;
  border: none;
  color: #0be321;
  outline: none;
  font-size: 20px;
}

.label {
  font-weight: bold;
}
</style>