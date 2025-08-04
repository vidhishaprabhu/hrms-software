import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../components/RegisterPage.vue'
import DashboardPage from '../components/DashboardPage.vue'
import AttendancePage from '../components/AttendancePage.vue'


const routes = [
  { path: '/register', name: 'RegisterPage', component: RegisterPage },
  { path: '/', name: 'DashboardPage', component: DashboardPage },
  { path: '/attendance', name: 'AttendancePage', component: AttendancePage },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
