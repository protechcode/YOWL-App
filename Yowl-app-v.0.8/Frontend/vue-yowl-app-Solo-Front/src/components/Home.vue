<template>
<div class="home">
    
    <h3 v-if="user">Hi, {{ user }} </h3>
    <h3 v-else>Hello, please log in to your account</h3>
</div>
</template>

<script>


    
    export default {
        name: 'Home',
        components:{
            
        },
       data(){
           return {
               user: localStorage.getItem('email')
           }
       }

        
    }

     /*  props:['user'] */
</script>
