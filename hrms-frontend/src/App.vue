<template>
<div id="app">
  <!-- Top Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to bottom right, #0077B6, #00B4D8); height: 60px;">
  <div class="container-fluid d-flex justify-content-between align-items-center px-4">
    
    <!-- Always show logo -->
    <div class="d-flex align-items-center">
      <img :src="require('@/assets/hrms-logo.png')" alt="Logo" style="height: 40px; margin-right: 10px;" />
    </div>
    <div class="text-white ml-8" style="padding-left:15%" v-if="showNavbarContent">Welcome, {{ userData.name }}</div>
    <BellOutlined style="color:white; font-size: 20px;padding-left:15%;padding-right:3%" v-if="showNavbarContent" />
    <div class="text-white" v-if="showNavbarContent">Month: {{ currentMonthYear }}</div>
    <template v-if="showNavbarContent">
      <div class="d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-14">
      <button class="btn btn-danger d-flex align-items-center gap-2" style="border: none;" @click="logout">
        <PoweroffOutlined />
        Logout
      </button>
    </div>
  </div>
    </template>

  </div>
</nav>
  <div class="d-flex" style="height: calc(100vh - 60px);">
    <SidebarPage v-if="showSidebar" />
    <div class="flex-grow-1 p-4" style="background-color: #f9f9f9;">
      <router-view />
    </div>
  </div>
  <footer class="footer">2025 © HR Management System designed by <span class="designer-name">Vidisha Prabhu B</span></footer>
</div>
</template>

<script>
import SidebarPage from './components/SidebarPage.vue';
import {
  PoweroffOutlined,
   BellOutlined 
} from '@ant-design/icons-vue';
import api from './api'; 
export default {
  name: 'App',
  components: {
    SidebarPage,
    PoweroffOutlined,
     BellOutlined 
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
.footer {
  background: linear-gradient(to bottom right, #0077B6, #00B4D8);
  color: #fff;
  text-align: center;
  padding: 12px 20px;
  font-size: 14px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  box-shadow: 0 -2px 5px rgba(0,0,0,0.1);

  position: fixed;
  bottom: 0;         
  left: 0;           
  width: 100%;       
  z-index: 1000;     
}

  html, body {
  height: 100%;
  margin: 0;
}

body {
  display: flex;
  flex-direction: column;
}

main {
  flex: 1; /* Pushes footer down */
}

  .designer-name {
    font-weight: bold;
    color: white; /* Yellow highlight */
  }

  .footer:hover {
    background:  #00B4D8;
    transition: background 0.3s ease;
  }
</style>
