<template>
  <div class="login-page">
    <div class="overlay">
      <div class="form-wrapper">
        <div class="card p-4 shadow-sm">
          <h2 class="text-center mb-4" style="color:#0077B6">Login</h2>
          <form @submit.prevent="register" >
            <div class="mb-3" >
              <input 
                type="email" 
                class="form-control" 
                placeholder="Enter your email" 
                v-model="email"
              />
            </div>
            <div class="mb-3">
              <input 
                type="password" 
                class="form-control" 
                placeholder="Enter your password" 
                v-model="password"
              />
            </div>
            <button 
              type="submit" 
              class="btn w-100" 
              style="background-color:#0077B6;color:white;border:1px solid blue"
              @click="login"
            >Login</button>
            <p v-if="error" class="text-danger text-center mt-3">{{ error }}</p>
            <p v-else-if="message" class="text-success text-center mt-3">{{ message }}</p>
          </form>
        </div>
        <p class="text-center mt-4 fw-bold fs-5" style="font-family:italic">
          Don't have an account ? 
          <router-link to="/register" style="color:#0077B6">Register</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api';

export default {
  name: 'LoginPage',
  data() {
    return {
      email: '',
      password: '',
      error: '',
      message: '',
      role: '',
    };
  },
  methods: {
    async login() {
      try {
        const response = await api.post('/login', {
          email: this.email,
          password: this.password,
        });

        const token = response.data.token;
        localStorage.setItem('api-token', token);
        const user = response.data.user
        localStorage.setItem('user-role', user.role);
        console.log("User",user);

        if (user && (user.role === 'admin' || user.role === 'hr')) {
          this.error = '';
          this.message = 'Login was Successfully done !!';
          window.location.href = '/admin-dashboard';
        } else {
          window.location.href = '/employee-dashboard';
        }

      } catch (error) {
        if (error.response && error.response.status === 422) {
          const errors = error.response.data.errors;
          if (errors.email) {
            this.error = errors.email[0];
          } else if (errors.name) {
            this.error = errors.name[0];
          } else if (errors.password) {
            this.error = errors.password[0];
          } else {
            this.error = 'Validation failed. Please check your inputs.';
          }
        } else {
          this.error = 'Login Failed !!. Please Try Again.';
        }
      }
    }
  }
};
</script>

<style scoped>
.login-page {
  background-image: url('@/assets/hrms-back.png');
  background-size: cover;
  background-position: center;
  min-height: 100vh;
}

.overlay {
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.form-wrapper {
  max-width: 400px; /* wider form */
  width: 100%;
}
</style>
