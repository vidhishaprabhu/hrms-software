<!-- src/components/Sidebar.vue -->
<template>
  <div
    class="sidebar d-flex flex-column p-3 shadow-sm"
    style="height: 100vh; width: 18%; background: linear-gradient(to bottom right, #0077B6, #00B4D8);"
  >
  
    <!-- Logo at the top -->
    <div class="text-center mb-4">
      <img :src="require('@/assets/hrms-logo.png')" alt="Logo" style="width: 120px; height: auto;" />
    </div>

    <!-- Navigation -->
    <ul class="nav flex-column">
      <a href=""><p class="text-white fw-bold">NAVIGATION</p></a>
      <li class="nav-item mb-3" v-for="item in navItems" :key="item.name">
        <router-link :to="item.route" class="nav-link text-white d-flex align-items-center sidebar-link">
          <!-- Use component dynamically -->
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
  LoginOutlined
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
    LoginOutlined
  },
  data() {
    return {
      navItems: [
        { name: 'Dashboard', route: '/', icon: 'DashboardOutlined' },
        { name: 'Attendance', route: '/attendance', icon: 'CalendarOutlined' },
        { name: 'Leave', route: '/leave', icon: 'LogoutOutlined' },
        { name: 'Approval', route: '/approval', icon: 'CheckCircleOutlined' },
        { name: 'Reports', route: '/reports', icon: 'BarChartOutlined' },
        { name: 'Payroll', route: '/payroll', icon: 'DollarOutlined' },
        { name: 'Shift Setup', route: '/shift-setup', icon: 'ClockCircleOutlined' },
        { name: 'Register', route: '/register', icon: 'UserAddOutlined' },
        { name: 'Login', route: '/login', icon: 'LoginOutlined' }
      ]
    };
  },
  computed: {
    navItemsWithIcons() {
      return this.navItems.map(item => ({
        ...item,
        icon: this.$options.components[item.icon]
      }));
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
