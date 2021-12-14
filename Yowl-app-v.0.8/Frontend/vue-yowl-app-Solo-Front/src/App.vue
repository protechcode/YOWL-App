<template>
  <div id="app">
    <!-- component nav -->
    <Nav />
    
    <div class="auth-wrapper">
      <div class="auth-inner">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>
<script>
import Nav from "./components/Nav.vue";


import { mapGetters } from "vuex";

export default {
  name: "App",
  components: {
    Nav,
  
  },
  computed: {
    ...mapGetters(['user'])
  }
  
};
</script>

<style>
@import url("https://fonts.googleapis.com/css?family=Fira+Sans:400,500,600,700,800");
* {
  box-sizing: border-box;
}

body {
  background-image: url("../public/backgroundApp.jpg") !important;
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
  min-height: 100vh;
  display: flex;
  font-weight: 400;
  font-family: "Fira Sans", sans-serif;
}

h1,
h2,
h3,
h4,
h5,
h6,
label,
span {
  font-weight: 500;
  font-family: "Fira Sans", sans-serif;
    color: white;

}

body,
html,
#app,
#root,
.auth-wrapper {
  width: 100%;
  height: 100%;
}

#app {
  text-align: center;
}

.navbar-light {
  background-color: #ffffff;
  box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
}

.auth-wrapper {
  display: flex;
  justify-content: center;
  flex-direction: column;
  text-align: left;
  
}

.auth-inner {
  background-color: #f80c0c3b;
  width: auto;
  max-height:690px;
  margin: auto;
  box-shadow: 0px 14px 80px rgba(34, 35, 58, 0.2);
  padding: 35px 15px 100px 15px;
  border-radius: 45px;
  transition: all 0.4s;
}

.auth-wrapper .form-control:focus {
  border-color: #167bff;
  box-shadow: none;
}

.auth-wrapper h3 {
  text-align: center;
  margin: 0;
  line-height: 1;
  padding-bottom: 20px;
}

.custom-contro-label {
  font-weight: 400;
}

.forgot-password,
.forgot-password a {
  text-align: right;
  font-size: 13px;
  padding-top: 10px;
  color: #7f7d7d;
  margin: 0;
}

.forgot-password a {
  color: #167bff;
}
</style>
