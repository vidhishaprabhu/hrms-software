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

      <!-- Loop through parent items -->
      <li class="nav-item mb-3" v-for="item in filteredNavItems" :key="item.name">
        
        <!-- If item has children -->
        <div v-if="item.children" class="text-white">
  <div 
    class="d-flex align-items-center sidebar-link"
    @click="toggleDropdown(item)"
    style="cursor: pointer;"
  >
    <component :is="item.icon" class="me-2" />
    <span>{{ item.name }}</span>
    <i 
      class="ms-auto"
      :class="item.isOpen ? 'bi bi-chevron-down' : 'bi bi-chevron-right'"
    ></i>
  </div>

  <ul v-show="item.isOpen" class="nav flex-column ms-4 mt-2">
    <li 
      v-for="child in item.children" 
      :key="child.name" 
      class="nav-item mb-2"
    >
      <router-link 
        :to="child.route" 
        class="nav-link text-white d-flex align-items-center sidebar-link"
      >
        <component :is="child.icon" class="me-3" />
        {{ child.name }}
      </router-link>
    </li>
  </ul>
</div>


        <!-- If no children (normal item) -->
        <router-link
          v-else
          :to="item.route"
          class="nav-link text-white d-flex align-items-center sidebar-link"
        >
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
  props: ["item"],
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
    InfoCircleOutlined,
  },
  data() {
    return {
      navItems: [
        { 
    name: 'Dashboard', 
    icon: 'DashboardOutlined',
    children: [
      { name: 'Admin Dashboard', route: '/admin-dashboard', icon: 'DashboardOutlined' },
      { name: 'Employee Dashboard', route: '/employee-dashboard', icon: 'DashboardOutlined' },
    ]
  },
        { name: 'Attendance', route: '/attendance', icon: 'CalendarOutlined' },
        { 
    name: 'Leave Info', 
    icon: 'InfoCircleOutlined',
    children: [
      { name: 'Leave Info', route: '/leave', icon: 'InfoCircleOutlined' },
      { name: 'Leave Add', route: '/leave-add', icon: 'PlusOutlined' },
    ]
  },
        { 
    name: 'Employee Info', 
    icon: 'InfoCircleOutlined',
    children: [
      { name: 'Employee Info', route: '/employee', icon: 'InfoCircleOutlined' },
      { name: 'Add Employee', route: '/employee-add', icon: 'PlusOutlined' },
      { name: 'Employee Details', route: '/employee-info', icon: 'InfoCircleOutlined' },
    ]
  },
        { name: 'Approval', route: '/approval', icon: 'CheckCircleOutlined' },
        { name: 'Reports', route: '/reports', icon: 'BarChartOutlined' },
        { name: 'Payroll', route: '/payroll', icon: 'DollarOutlined' },
        { name: 'Shift Setup', route: '/shift-setup', icon: 'ClockCircleOutlined' },
        { name: 'Register', route: '/register', icon: 'UserAddOutlined', loggedIn: false },
        { name: 'Login', route: '/', icon: 'LoginOutlined', loggedIn: false },
      ]
    };
  },
  computed: {
    isAuthenticated() {
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
    },
    toggleDropdown(item) {
      item.isOpen = !item.isOpen;
    }
  }
};
</script>

<style scoped>
.sidebar-link {
  padding: 8px 12px;
  border-radius: 6px;
  color: white !important; /* always white text */
  transition: background 0.3s, color 0.3s;
}

.sidebar-link:hover {
  background-color: white; /* semi-transparent white */
  color: #0077B6 !important; /* keep text white */
  text-decoration: none;
}

/* Active link highlight */
.router-link-active,
.router-link-exact-active {
  background-color: white; 
  color: #0077B6 !important;
  border-radius: 6px;
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
