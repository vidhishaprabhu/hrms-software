<template>
<div id="app">
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to bottom right, #0077B6, #00B4D8); height: 60px;">
  <div class="container-fluid d-flex justify-content-between align-items-center px-4">
    
    <!-- Always show logo -->
    <div class="d-flex align-items-center">
      <img :src="require('@/assets/hrms-logo.png')" alt="Logo" style="height: 40px; margin-right: 10px;" />
    </div>

    <!-- Show this only when not on login/register -->
    <template v-if="showNavbarContent">
      <div class="text-white">Month: {{ currentMonthYear }}</div>
      <div class="d-flex justify-content-end align-items-center gap-3">
        <div class="text-white">Welcome, {{userData.name}}</div>
        <button class="btn btn-danger d-flex align-items-center gap-2" style="border: none;" @click="logout">
          <PoweroffOutlined />
          Logout
        </button>
      </div>
    </template>

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
import api from './api'; 
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
      }),
      userData: {}
    };
  },
  computed: {
    showSidebar() {
      return this.$route.path !== '/' && this.$route.path !== '/register';
    },
    showNavbarContent() {
    return this.$route.path !== '/' && this.$route.path !== '/register';
  },

  },
  mounted() {
    this.getUser();
  },
  methods: {
    async logout() {
  try {
    const token = localStorage.getItem('api-token');
    if (!token) {
      alert("No token found. Please log in again.");
      return;
    }

    await api.post('/logout', {}, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });

    localStorage.removeItem('api-token');
    this.$store.commit('clearCheckInTime');

    if (this.user_id) {
      localStorage.removeItem(`checkInTime_${this.user_id}`);
    }

    this.checkInTime = null;  // <-- reset local checkInTime data

    alert("User logged out successfully");
    this.$router.push('/');

  } catch (error) {
    console.error("Logout error:", error);
    alert("Logout failed. Please try again.");
  }
},

    async getUser(){
      try {
        const response = await api.get('/user');
        this.userData = response.data;
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    }

  }
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
