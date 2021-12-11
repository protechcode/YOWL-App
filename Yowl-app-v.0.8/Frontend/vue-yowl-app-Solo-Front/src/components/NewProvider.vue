<template>
    <div>
        <Button/>
        <form @submit.prevent="handleSubmit">
        <h3>Sign Up as a Provider</h3>

        <div class="form-group">
            <label>Organization Name</label>
            <input type="text" class="form-control" v-model="name" placeholder="First Name"/>
        </div>

         
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="email" placeholder="Email"/>
        </div>

        <div class="form-group">
            <lablel>Password</lablel>
            <input type="password" class="form-control" v-model="password" placeholder="Password"/>
        </div>

        <div class="form-group">
            <lablel>Confirm Password</lablel>
            <input type="password" class="form-control" v-model="password_confirm" placeholder="Confirm Password"/>
        </div>

        <button class="btn btn-primary btn-block">Sign Up</button>
        </form>
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

