import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../components/RegisterPage.vue'
import DashboardPage from '../components/DashboardPage.vue'
import AttendancePage from '../components/AttendancePage.vue'
import LoginPage from '../components/LoginPage.vue'
import EmployeeDashboard from '../components/EmployeeDashboard.vue'
const routes = [
  { path: '/register', name: 'RegisterPage', component: RegisterPage },
  { path: '/admin-dashboard', name: 'DashboardPage', component: DashboardPage,meta: { requiresAuth: true } ,role: 'admin'},
  { path: '/attendance', name: 'AttendancePage', component: AttendancePage,meta: { requiresAuth: true },role: 'admin' },
  { path: '/', name: 'LoginPage', component: LoginPage },
  { path: '/employee-dashboard', name: 'EmployeeDashboard', component: EmployeeDashboard,meta: { requiresAuth: true }, role: 'employee' },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('api-token');
  const userRole = localStorage.getItem('user-role');

  if (to.meta.requiresAuth) {
    if (!token) {
      next('/login');
    } else {
      if (to.meta.role && to.meta.role !== userRole) {
        alert('Access Denied: Unauthorized Role');
        next('/login');
      } else {
        next();
      }
    }
  } else {
    next();
  }
});

export default router
