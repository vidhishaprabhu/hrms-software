<template>
<div id="app">
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background:  linear-gradient(to bottom right, #0077B6, #00B4D8);; height: 60px;">
    <div class="container-fluid d-flex justify-content-between align-items-center px-4">
      <div class="d-flex align-items-center">
        <img :src="require('@/assets/hrms-logo.png')" alt="Logo" style="height: 40px; margin-right: 10px;" />
      </div>

      <div class="text-white">Month: {{ currentMonthYear }}</div>
      <div class="d-flex justify-content-end align-items-center gap-3">
        <div class="text-white">Welcome, Admin</div>
        <button class="btn btn-danger d-flex align-items-center gap-2" style="border: none;">
          <PoweroffOutlined />
          Logout
        </button>
      </div>

    </div>
  </nav>

  <!-- Main Body: Sidebar + Router View -->
  <div class="d-flex" style="height: calc(100vh - 60px);">
    <SidebarPage v-if="showSidebar" />
    <div class="flex-grow-1 p-4" style="background-color: #f9f9f9;">
      <router-view />
    </div>
  </div>
</div>
</template>

<script>
import SidebarPage from './components/SidebarPage.vue';
import {
  PoweroffOutlined
} from '@ant-design/icons-vue';

export default {
  name: 'App',
  components: {
    SidebarPage,
    PoweroffOutlined
  },
  data() {
    return {
      currentMonthYear: new Date().toLocaleString('default', {
        month: 'short',
        year: 'numeric'
      })
    };
  },
  computed: {
    showSidebar() {
      return this.$route.path !== '/login' && this.$route.path !== '/register';
    }
  },
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin: 0;
}
</style>
