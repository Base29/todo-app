<template>
  <div>
      <div v-if="loading">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
      </div>
      <div v-else>
          Logged in 
      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name: "Dashboard",
    data() {
        return {
            loading: true
        }
    },
    mounted() {
        if (this.$store.state.token !== '') {
            axios.post('/api/checktoken', {token: this.$store.state.token})
            .then(res => {
                this.loading = false;
            })
            .catch(err => {
                this.loading = false;
                this.$store.commit('clearToken');
                this.$router.push('/login');
            })
        } else {
            this.$router.push('/login');
            this.loading = false;
        }
    },
}
</script>

<style>

</style>