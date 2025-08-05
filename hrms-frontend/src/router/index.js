import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../components/RegisterPage.vue'
import DashboardPage from '../components/DashboardPage.vue'
import AttendancePage from '../components/AttendancePage.vue'
import LoginPage from '../components/LoginPage.vue'

const routes = [
  { path: '/register', name: 'RegisterPage', component: RegisterPage },
  { path: '/', name: 'DashboardPage', component: DashboardPage },
  { path: '/attendance', name: 'AttendancePage', component: AttendancePage },
  { path: '/login', name: 'LoginPage', component: LoginPage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
