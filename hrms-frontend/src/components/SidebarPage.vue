<!-- src/components/Sidebar.vue -->
<template>
  <div
    class="sidebar d-flex flex-column p-3 shadow-sm"
    style="height: 100vh; width: 18%; background: linear-gradient(to bottom right, #0077B6, #00B4D8);"
  >
    <div class="text-center mb-4">
      <img :src="require('@/assets/hrms-logo.png')" alt="Logo" style="width: 120px; height: auto;" />
    </div>
    <ul class="nav flex-column">
      <a href=""><p class="text-white fw-bold">NAVIGATION</p></a>
      <li class="nav-item mb-3" v-for="item in filteredNavItems" :key="item.name">
        <router-link :to="item.route" class="nav-link text-white d-flex align-items-center sidebar-link">
          <component :is="item.icon" class="me-4" />
          {{ item.name }}
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import {
  DashboardOutlined,
  CalendarOutlined,
  LogoutOutlined,
  CheckCircleOutlined,
  BarChartOutlined,
  DollarOutlined,
  ClockCircleOutlined,
  UserAddOutlined,
  LoginOutlined,
 PlusOutlined,
 InfoCircleOutlined
} from '@ant-design/icons-vue';

export default {
  components: {
    DashboardOutlined,
    CalendarOutlined,
    LogoutOutlined,
    CheckCircleOutlined,
    BarChartOutlined,
    DollarOutlined,
    ClockCircleOutlined,
    UserAddOutlined,
    LoginOutlined,
    PlusOutlined,
    InfoCircleOutlined
  },
  data() {
    return {
      navItems: [
        { name: 'Admin Dashboard', route: '/admin-dashboard', icon: 'DashboardOutlined', roles: ['admin', 'hr'] },
        { name: 'Employee Dashboard', route: '/employee-dashboard', icon: 'DashboardOutlined', roles: ['employee', 'user'] },
        { name: 'Attendance', route: '/attendance', icon: 'CalendarOutlined' },
        { name: 'Leave Info', route: '/leave', icon: 'InfoCircleOutlined' },
        { name: 'Leave Add', route: '/leave-add', icon: 'PlusOutlined' },
        { name: 'Employee Info', route: '/employee-info', icon: 'InfoCircleOutlined' },
        { name: 'Approval', route: '/approval', icon: 'CheckCircleOutlined' },
        { name: 'Reports', route: '/reports', icon: 'BarChartOutlined' },
        { name: 'Payroll', route: '/payroll', icon: 'DollarOutlined' },
        { name: 'Shift Setup', route: '/shift-setup', icon: 'ClockCircleOutlined' },
        { name: 'Register', route: '/register', icon: 'UserAddOutlined', loggedIn: false },
        { name: 'Login', route: '/', icon: 'LoginOutlined', loggedIn: false },
        // { name: 'Logout', route: '/logout', icon: 'LogoutOutlined', loggedIn: true }
      ]
    };
  },
  computed: {
    isAuthenticated() {
      // Check if the user is authenticated by looking for a token in local storage
      return localStorage.getItem('api-token') !== null;
    },
    filteredNavItems() {
      const userRole = localStorage.getItem('user-role');
      const isAuthenticated = this.isAuthenticated;

      return this.navItems.filter(item => {
        // Handle login/register vs. authenticated links
        if (item.loggedIn !== undefined) {
          if (item.loggedIn && !isAuthenticated) {
            return false;
          }
          if (!item.loggedIn && isAuthenticated) {
            return false;
          }
        }

        // Handle role-based access for dashboard items
        if ((item.name === 'Admin Dashboard' && item.name === 'Attendance' && item.name==='Leave Add') ) {
          // Check if the user's role is included in the item's allowed roles
          return item.roles && item.roles.includes(userRole);
        }
        
        // Show all other links by default for authenticated users
        return isAuthenticated; 
      });
    }
  },
  methods: {
    // You might also need a method to handle the logout logic
    logout() {
      localStorage.removeItem('api-token');
      localStorage.removeItem('user-role');
      window.location.href = '/'; // Redirect to the login page
    }
  }
};
</script>

<style scoped>
.sidebar-link {
  padding: 8px 12px;
  transition: background 0.3s, color 0.3s;
}
.sidebar-link:hover {
  background-color: rgba(255, 255, 255, 0.2);
  color: #fff;
  text-decoration: none;
}
body,
html {
  margin: 0;
  padding: 0;
}
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
}
</style>
