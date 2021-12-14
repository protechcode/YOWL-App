<template>
    <div>
        
        <form @submit.prevent="handleSubmit">
        <h3>Sign Up as a Provider</h3>

        <div class="form-group">
            <label>Organization Name</label>
            <input type="text" class="form-control" v-model="name" placeholder="First Name" required/>
        </div>

         
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="email" placeholder="Email" required/>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" v-model="password" placeholder="Password" required/>
        </div>

        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password" class="form-control" v-model="password_confirm" placeholder="Confirm Password" required/>
        </div>

        <button class="btn btn-primary btn-block">Sign Up</button>
        </form>
        <Button/>
    </div>
</template>

<script>
    import axios from 'axios'
    import Button from './Button.vue'

    export default{
        name: 'NewProvider',
        components:{
            Button,
        },
        data() {
            return {
                name: '',
                surname: '',
                email: '',
                password: '',
                password_confirm: '',
            }
        },
        methods: {
            async handleSubmit(){
               await axios.post('v1/provider/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirm: this.password_confirm

                });
                /* const response =  console.log(response); */
                this.$router.push('/login');    
               

                
                    

            }
        }
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