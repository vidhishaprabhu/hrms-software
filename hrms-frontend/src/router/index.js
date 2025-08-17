import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../components/RegisterPage.vue'
import DashboardPage from '../components/DashboardPage.vue'
import AttendancePage from '../components/AttendancePage.vue'
import LoginPage from '../components/LoginPage.vue'
import EmployeeDashboard from '../components/EmployeeDashboard.vue'
import AddLeave from '../components/AddLeave.vue';
const routes = [
  { path: '/register', name: 'RegisterPage', component: RegisterPage },
  { path: '/admin-dashboard', name: 'DashboardPage', component: DashboardPage,meta: { requiresAuth: true, role: 'admin' } },
  { path: '/attendance', name: 'AttendancePage', component: AttendancePage,meta: { requiresAuth: true, role: 'admin' } },
  { path: '/', name: 'LoginPage', component: LoginPage },
  { path: '/employee-dashboard', name: 'EmployeeDashboard', component: EmployeeDashboard,meta: { requiresAuth: true, role: 'employee' } },
  { path: '/leave-add', name: 'AddLeave', component: AddLeave,meta: { requiresAuth: true, role: 'admin' } },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('api-token');
  const userRole = localStorage.getItem('user-role');

  console.log("User Role:", userRole, "Route Role:", to.meta.role); // debug

  if (to.meta.requiresAuth) {
    if (!token) {
      next('/');
    } else {
      // Only block if both roles exist and they don't match (case-insensitive)
      if (to.meta.role && userRole && to.meta.role.toLowerCase() !== userRole.toLowerCase()) {
        alert('Access Denied: Unauthorized Role');
        next('/employee-dashboard');
      } else {
        next();
      }
    }
  } else {
    next();
  }
});


export default router
