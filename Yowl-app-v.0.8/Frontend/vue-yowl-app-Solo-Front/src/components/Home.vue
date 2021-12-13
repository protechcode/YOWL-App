<template>
  <div class="home">
    <div class="logo">
        <img src="tell-me-opp-logo.png" width="300" height="300" style="vertical-align:middle;margin:0px 50px">
    </div>

    <h3 v-if="user">Hi, {{ user }}</h3>
    <h3 v-else>Hello, please log in to your account</h3>
    <AddComment/>

  </div>
</template>

<script>
import AddComment from "./AddComment.vue"
export default {
  name: "Home",
  components: {
    AddComment,
  },
  data() {
    return {
      user: localStorage.getItem("email"),
    };
  },
};

/*  props:['user'] */
</script>

<style scoped>
  .logo {
    border: 1px solid black;
    border-radius: 10px; 
    margin: 20px;
  }
  
</style>
