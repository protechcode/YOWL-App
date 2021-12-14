<template>
    <div>
        
        <form @submit.prevent="handleSubmit">
            <h3>Login as a Provider</h3>

            <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" v-model="email" placeholder="Email" required/>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" v-model="password" placeholder="Password" required/>
            </div>

            <button class="btn btn-primary btn-block">Login</button>
        </form>
        <ButtonLogin/>
    </div>
</template>

<script>
import axios from 'axios'
import ButtonLogin from './ButtonLogin.vue'
    export default {
        name: 'LoginProvider',
        components:{
            ButtonLogin
        },
        data () {
            return {
                email: '',
                password: '',
                userId:'',
                
            }
        },
        methods:{
            async handleSubmit(){

                const response = await axios.post('/v1/provider/login', {
                    email: this.email,
                    password: this.password
                }).catch(e =>{
                    console.log(e);
                });
                console.log(this.email)
                console.log(this.password)
                console.log(response)
                localStorage.setItem('token', response.data.token);
                localStorage.setItem('email', this.email)
                localStorage.setItem('userId', response.data.user.id )
                this.$store.dispatch('user', response.data.user);
                this.$router.push('/');
                
                


            }
        },
    }
</script>

<style scoped>
form {
    padding: 30px;
}
    /* .auth-inner {
        margin: 0;
    } */
</style>