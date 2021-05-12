<template>
<div>
    <div v-if="loading">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="login" v-else>
    <h2>Login</h2>
    <form class="form">
        <div class="form-group">
            <input class="form-control" placeholder="Email" v-model="credentials.email"/>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Password" type="password" v-model="credentials.password" />
        </div>
        <button class="btn btn-primary" @click.prevent="login">Login</button>
    </form>

</div>
</div>
</template>

<script>
import axios from 'axios';
export default {
    name: "Login",
    data() {
        return {
            credentials: {
                email: '',
                password:''
            },
            loading: true,
        }
    },
    mounted() {
        this.$store.commit('setCurrentRoute', this.$router.currentRoute.name);
        if (this.$store.state.token !== '') {
            axios.post('api/checktoken', {token: this.$store.state.token})
            .then(res => {
                if (res.data.success) {
                    this.loading = false;
                    this.$router.push('/dashboard');
                } 
            })
            .catch(err => {
                console.log('TOKEN VALIDATION ERROR', err);
                this.loading = false;
                this.$store.commit('clearToken');
            })
        } else {
            this.loading = false;
        }
    },
    methods: {
        login() {
            axios.post('api/login', this.credentials).then(res => {
                if (res.data.success) {
                    // Update the store
                    this.$store.commit('setToken', res.data.token);
                    this.$router.push('/dashboard').catch((err) => console.log('ROUTER ERROR', err));
                }
            }).catch(err => console.log('LOGIN ERROR', err));
        }
    }
}
</script>

<style scoped>
.login {
    background-color: #fff;
    border: 1px solid #eee;
    padding: 10px;
    margin: 50px auto;
    width: 40%;
    height: 70%;
}

button {
    display: block;
    margin: 0 auto;
}
.login h2 {
    margin-bottom: 20px;
}
</style>