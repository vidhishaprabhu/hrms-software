import { createRouter, createWebHistory } from 'vue-router'
// import Home from '../components/Home.vue'
import RegisterPage from '../components/RegisterPage.vue'
import DashboardPage from '../components/DashboardPage.vue'
// import Login from '../components/Login.vue'

const routes = [
  // { path: '/', name: 'Home', component: Home },
  { path: '/register', name: 'RegisterPage', component: RegisterPage },
  { path: '/', name: 'DashboardPage', component: DashboardPage },
  // { path: '/login', name: 'Login', component: Login },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
