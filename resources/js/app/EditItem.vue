<template>
  <div>
    <div v-if="loading">
      <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
    <div class="update-item" v-else>
      <h2>Edit Item</h2>
      <form class="form">
        <div class="form-group">
          <input class="form-control" v-model="title" />
        </div>
        <div class="form-group">
          <input class="form-control" v-model="description" />
        </div>
        <div class="action-buttons">
          <div class="left-col">
            <button class="btn btn-primary btn-block" @click.prevent="update">
              UPDATE
            </button>
            <button
              class="btn btn-secondary btn-block"
              @click.prevent="backToDashboard"
            >
              CANCEL
            </button>
          </div>
          <div class="right-col">
            <button class="btn btn-success btn-block" @click.prevent="markDone">
              DONE
            </button>
            <button
              class="btn btn-danger btn-block"
              @click.prevent="removeItem"
            >
              DELETE
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import API_URL from "./config";
export default {
  name: "EditItem",
  data() {
    return {
      title: "",
      description: "",
      loading: true,
    };
  },
  mounted() {
    if (this.$store.state.token !== "") {
      const endpoint = `${API_URL}/checktoken`;
      axios
        .post(endpoint, { token: this.$store.state.token })
        .then((res) => {
          this.loading = false;
          this.getItemData();
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
    getItemData() {
      const itemId = this.$route.params.itemId;
      const endpoint = `${API_URL}/item/${itemId}`;
      axios
        .get(endpoint, {
          headers: {
            Authorization: `Bearer ${this.$store.state.token}`,
          },
        })
        .then((response) => {
          if (response.data.success) {
            const { title, description } = response.data.item;
            this.title = title;
            this.description = description;
          }
        })
        .catch((err) => console.log("SINGLE ITEM GET ERROR", err));
    },
    update() {
      const itemId = this.$route.params.itemId;
      const endpoint = `${API_URL}/item/${itemId}`;
      const data = {
        title: this.title,
        description: this.description,
      };
      const header = {
        headers: {
          Authorization: `Bearer ${this.$store.state.token}`,
        },
      };
      axios
        .put(endpoint, data, header)
        .then((response) => {
          if (response.data.success) {
            this.$router.push("/dashboard");
          }
        })
        .catch((err) => console.log("UPDATE ERROR", err));
    },
    backToDashboard() {
      this.$router.back();
    },

    markDone() {
      // this.done = !this.item.completed;
      const itemId = this.$route.params.itemId;
      const endpoint = `${API_URL}/done/${itemId}`;
      const header = {
        headers: {
          Authorization: `Bearer ${this.$store.state.token}`,
        },
      };
      const data = {
        done: !this.$route.params.isCompleted,
      };
      axios
        .put(endpoint, data, header)
        .then((response) => {
          if (response.data.success) {
            console.log("MARK DONE RES", response.data);
            this.$router.push("/dashboard");
          }
        })
        .catch((error) => {
          console.log("error".error);
        });
    },

    removeItem() {
      const itemId = this.$route.params.itemId;
      const endpoint = `${API_URL}/item/${itemId}`;
      const header = {
        headers: {
          Authorization: `Bearer ${this.$store.state.token}`,
        },
      };
      axios
        .delete(endpoint, header)
        .then((response) => {
          if (response.data.success) {
            this.$router.push("/dashboard");
          }
        })
        .catch((error) => console.log("error".error));
    },
  },
};
</script>

<style>
.action-buttons {
  display: flex;
  width: 100%;
}

.left-col {
  width: 50%;
  padding: 2px;
}

.right-col {
  width: 50%;
  padding: 2px;
}
.update-item {
  background-color: #fff;
  border: 1px solid #eee;
  padding: 10px;
  margin: 50px auto;
  width: 40%;
  height: 70%;
}

.update-item h2 {
  margin-bottom: 20px;
}
</style>