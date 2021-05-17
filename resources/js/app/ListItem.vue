<template>
  <div class="item-container">
    <div class="item-data">
      <span class="label">Title: </span>
      <span :class="[this.done ? 'completed' : '', 'itemText']">{{
        item.title
      }}</span>
      <br />
      <span class="label">Description: </span>
      <span :class="[this.done ? 'completed' : '', 'itemText']">{{
        item.description
      }}</span>
    </div>
    <div class="action-container">
      <div class="done-btn">
        <button
          :class="[this.done ? 'chkBox-done' : 'chkBox']"
          @click="markDone()"
        >
          <font-awesome-icon icon="check-square" />
        </button>
      </div>
      <div class="edit-btn">
        <button
          :class="this.done ? 'editpen-disabled' : 'editpen'"
          @click="editItem()"
          :disabled="this.done"
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
        done: this.done,
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