<template>
<div class="login">
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
    methods: {
        login() {
            axios.post('api/login', this.credentials).then(res => {
                if (res.data.success) {
                    // Update the store

                console.log(res.data);
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
    width: 500px;
}

button {
    display: block;
    margin: 0 auto;
}
</style>