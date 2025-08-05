<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4 shadow-sm">
          <h2 class="text-center mb-4" style="background-color:#e3f2fd">Register</h2>
          <form @submit.prevent="register">
            <div class="mb-3">
              <input 
                type="text" 
                class="form-control" 
                placeholder="Enter your name" 
                v-model="name"
              />
            </div>
            <div class="mb-3">
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
            <div class="mb-3">
              <select class="form-control" v-model="role">
                <option disabled value="">Select Role</option>
                <option value="admin">Admin</option>
                <option value="employee">Employee</option>
              </select>
            </div>

            <button type="submit" class="btn w-100" style="background-color:#e3f2fd;border:1px solid blue">Register</button>
            <p v-if="error" class="text-danger text-center mt-3">{{ error }}</p>
            <p v-else-if="message" class="text-success text-center mt-3">{{ message }}</p>
          </form>
        </div>
        <p class="text-center mt-4 fw-bold fs-5">
          Already have an account? 
          <router-link to="/login" class="text-danger fw-bold">Login</router-link>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api';

export default {
  name: 'RegisterPage',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      error: '',
      message: '',
      role: '',
    };
  },
  methods: {
    async register() {
      try {
        await api.post('/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          role: this.role,
        });

        this.error = '';
        this.message = 'Registration was Successfully done !!';

        setTimeout(() => {
          this.$router.push('/login');
        }, 1000);

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
          this.error = 'Registration Failed !!. Please Try Again.';
        }
      }
    }
  }
};
</script>

<style scoped>
/* Optional styling */
</style>
