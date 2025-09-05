import { createRouter, createWebHistory } from 'vue-router'
import RegisterPage from '../components/RegisterPage.vue'
import DashboardPage from '../components/DashboardPage.vue'
import AttendancePage from '../components/AttendancePage.vue'
import LoginPage from '../components/LoginPage.vue'
import EmployeeDashboard from '../components/EmployeeDashboard.vue'
import AddLeave from '../components/AddLeave.vue';
import ApplyLeavePage from '../components/ApplyLeavePage.vue';
import EmployeeInfo from '../components/EmployeeInfo.vue';
import EmployeeProfile from '../components/EmployeeProfile.vue';
import EmployeeAdd from '../components/AddEmployee.vue';
import ChangePassword from '../components/ChangePassword.vue';
import EmployeesDisplay from '../components/EmployeesDisplay.vue';
import LeaveInfo from '../components/LeaveInfo.vue';
import AttendanceDashboard from '../components/AttendanceDashboard.vue';
import GetReport from '../components/GetReport.vue';
import CreateJob from '../components/CreateJob.vue';
import JobDescription from '../components/JobDescription.vue';
import NewJoineeReport from '../components/NewJoineeReport.vue';

const routes = [
  { path: '/register', name: 'RegisterPage', component: RegisterPage },
  { path: '/admin-dashboard', name: 'DashboardPage', component: DashboardPage,meta: { requiresAuth: true, role: 'admin' } },
  { path: '/attendance', name: 'AttendancePage', component: AttendancePage,meta: { requiresAuth: true, role: 'admin' } },
  { path: '/', name: 'LoginPage', component: LoginPage },
  { path: '/employee-dashboard', name: 'EmployeeDashboard', component: EmployeeDashboard,meta: { requiresAuth: true, role: 'employee' } },
  { path: '/leave-add', name: 'AddLeave', component: AddLeave,meta: { requiresAuth: true, role: 'admin' } },
  {
    path: '/apply-leave/:type',
    name: 'apply-leave',
    component: ApplyLeavePage,
    props: true,
    meta: { requiresAuth: true, role: 'employee'}
  },
  {
    path: '/employee-info',
    name: 'EmployeeInfo',
    component: EmployeeInfo,
    meta: { requiresAuth: true, role: 'employee'}
  },
  {
    path: '/employee-profile',
    name: 'EmployeeProfile',
    component: EmployeeProfile,
    meta: { requiresAuth: true}
  },
  {
    path: '/employee-add',
    name: 'EmployeeAdd',
    component: EmployeeAdd,
    meta: { requiresAuth: true, role: 'admin'}
  },
  {
    path:'/change-password',
     name: 'ChangePassword',
    component: ChangePassword,
    meta: { requiresAuth: true}
  },
  {
    path:'/employees',
    name: 'EmployeesDisplay',
    component: EmployeesDisplay,
    meta: { requiresAuth: true,role:'admin'}
  },
  {
    path:'/leave-info',
    name: 'LeaveInfo',
    component:LeaveInfo,
    meta: { requiresAuth: true,role:'admin'}
  },
  {
    path:'/attendance-dashboard',
    name: 'AttendanceDashboard',
    component:AttendanceDashboard,
    meta: { requiresAuth: true, role:'admin'}
  },  
  {
    path:'/get-report',
    name: 'GetReport',
    component:GetReport,
    meta: { requiresAuth: true, role:'admin'}
  },
  {
    path:'/create-job',
    name: 'CreateJob',
    component:CreateJob,
    meta: { requiresAuth: true, role:'admin'}
  },
  {
    path:'/job-description',
    name: 'JobDescription',
    component:JobDescription,
    meta: { requiresAuth: true, role:'admin'},
    props: true
  },
  {
    path:'/new-joinee-report',
    name: 'NewJoineeReport',
    component:NewJoineeReport,
    meta: { requiresAuth: true, role:'admin'},
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
});
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('api-token');
  const userRole = localStorage.getItem('user-role');

  console.log("User Role:", userRole, "Route Role:", to.meta.role);

  if (to.meta.requiresAuth) {
    if (!token) {
      next('/'); 
    } else {
      if (to.meta.role && userRole && to.meta.role.toLowerCase() !== userRole.toLowerCase()) {
        alert('Access Denied: Unauthorized Role');

        if (userRole.toLowerCase() === 'admin') {
          next('/admin-dashboard');
        } else if (userRole.toLowerCase() === 'employee') {
          next('/employee-dashboard');
        } else {
          next('/'); 
        }

      } else {
        next(); // allowed route
      }
    }
  } else {
    next(); // public route
  }
});



export default router
