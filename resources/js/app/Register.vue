<template>
<div>
    <div v-if="loading">
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="register" v-else>
    <h2>Register</h2>
    <form class="form">
        <div class="form-group">
            <input class="form-control" placeholder="Email" v-model="credentials.email"/>
        </div>
        <div class="form-group">
            <input class="form-control" placeholder="Password" type="password" v-model="credentials.password" />
        </div>
        <button class="btn btn-primary" @click.prevent="register">Register</button>
    </form>

</div>
</div>
</template>

<script>
import axios from 'axios';
export default {
    name: "Register",
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
        register() {
            axios.post('api/register', this.credentials).then(res => {
                if (res.data.success) {
                    this.$router.push('/login').catch((err) => console.log('ROUTER ERROR', err));
                }
            }).catch(err => console.log('REGISTER ERROR', err));
        }
    }
}
</script>

<style scoped>
.register {
    background-color: #fff;
    border: 1px solid #eee;
    padding: 10px;
    margin: 50px auto;
    width: 40%;
    height: 70%;
}

.register h2 {
    margin-bottom: 20px;
}

button {
    display: block;
    margin: 0 auto;
}
</style>