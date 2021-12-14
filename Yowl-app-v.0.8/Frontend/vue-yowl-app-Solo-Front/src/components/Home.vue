<template>
  <div class="home">
    <div class="logo">
        <img src="tell-me-opp-logo2.png" width="300" height="300" style="vertical-align:middle;margin:0px 50px">
    </div>
  
    <div v-if="token">
      <h3 >Hi, {{ user }}</h3>
       <NewsFeed />
    </div>
    <h3 v-else>Hello, please log in to your account</h3>
    

  </div>
</template>

<script>
import NewsFeed from "./NewsFeed";
export default {
  name: "Home",
  components: {
    NewsFeed,
  },
  data() {
    return {
      user: localStorage.getItem("userName"),
      token: localStorage.getItem("token"),
    };
  },
};

/*  props:['user'] */
</script>

<style scoped>
.logo {
  margin: 20px;
}
</style>
