import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'
import Login from '../components/Login.vue'
import Register from '../components/Register.vue'
import NewProvider from '../components/NewProvider.vue'
import LoginProvider from '../components/LoginProvider.vue'
import WriteReview from '../components/WriteReview.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/login',
    name: 'Login',
    component: Login
  },
  {
    path: '/register',
    name: 'Register',
    component: Register
  },
  {
    path:'/provider/register',
    name: 'NewProvider',
    component: NewProvider
  },
  {
    path:'/provider/login',
    name: 'LoginProvider',
    component: LoginProvider
  },
  {
    path:'/review',
    name: 'WriteReview',
    component: WriteReview
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
