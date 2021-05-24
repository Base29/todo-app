<template>
  <div class="main">
    <div v-if="isVerified === null" class="response-container">
      <div class="icon">
        <font-awesome-icon icon="hand-paper" class="halt" />
      </div>
      <span class="text">Please Wait</span>
    </div>
    <div v-else-if="isVerified" class="response-container">
      <div class="icon">
        <font-awesome-icon icon="check-circle" class="success" />
      </div>
      <span class="text">{{ message }}</span>
    </div>
    <div v-else class="response-container">
      <div class="icon">
        <font-awesome-icon icon="times-circle" class="fail" />
      </div>
      <span class="text">{{ message }}</span>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import API_URL from "./config";
export default {
  name: "VerifyEmail",
  data() {
    return {
      isVerified: null,
      message: "",
    };
  },
  mounted() {
    this.$store.commit("setCurrentRoute", this.$router.currentRoute.name);
  },
  methods: {
    async verifyEmail() {
      const endpoint = `${API_URL}/email-verification`;
      await axios
        .get(endpoint, {
          params: this.$route.query,
        })
        .then((response) => {
          console.log("RESPONSE", response);
          const { success, message } = response.data;
          if (success) {
            this.isVerified = true;
            this.message = message;
          } else {
            this.isVerified = false;
            this.message = message;
          }
        })
        .catch((err) => console.log("EMAIL VERIFICATION ERROR", err));
    },
  },
  created() {
    console.log(this.$route.query);
    this.verifyEmail();
  },
};
</script>

<style>
.main {
  display: flex;
  justify-content: center;
}
.response-container {
  padding: 20px;
}
.success {
  background: none;
  border: none;
  color: #02f527;
  outline: none;
  font-size: 100px;
}

.fail {
  background: none;
  border: none;
  color: #ff0000;
  outline: none;
  font-size: 100px;
}

.text {
  font-size: 40px;
}

.icon {
  display: flex;
  justify-content: center;
}

.halt {
  background: none;
  border: none;
  color: #ffffff;
  outline: none;
  font-size: 100px;
}
</style>