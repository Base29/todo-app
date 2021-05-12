<template lang="">
    <div>
        <nav class="navbar navbar-dark bg-dark">
           <div class="links">
                <!-- <div>
                    <router-link to="/">Home</router-link>
                </div>
                <div>
                    <router-link to="/login">Login</router-link>
                </div>
                <div>
                    <router-link to="/dashboard">Dashboard</router-link>
                </div> -->
           </div>
            <div class='logout' v-if="this.$store.state.token !== ''">
                <button class="btn btn-info" @click="logout">Logout</button>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>
<script>
import axios from 'axios';
export default {
    name: 'App',
    mounted () {
        if (this.$store.state.token !== '') {
            axios.post('/api/checktoken', {token: this.$store.state.token})
            .then(res => {
                if (res.data.success) {
                    this.$router.push('/dashboard').catch((err) => console.log('ROUTER ERROR', err));
                }
            })
            .catch(err => {
                this.$store.commit('clearToken');
                this.$router.push('/login').catch((err) => console.log('ROUTER ERROR', err));
            })
        } else {
            this.$store.commit('clearToken');
            this.$router.push('/login');
        }
    },
    methods: {
        logout() {
            axios.post('/api/logout', {token: this.$store.state.token})
            .then(res => {
                if (res.data.success) {
                    this.$store.commit('clearToken');
                    this.$router.push('/login').catch((err) => console.log('ROUTER ERROR', err));
                }
            }).catch(err => console.log('LOGOUT ERROR', err));
        }
    }
}
</script>
<style scoped>

.navbar {
    display: flex;
    height: 70px;
    background-color: #fff;
    border-bottom: 1px solid #eee;

}

.navbar div {
    padding: 5px 20px;
    margin: 5px 5px;
}

.logout {
    align-self: flex-end;
}
.links {
    display: flex;
    align-self: flex-start;
}
    
</style>