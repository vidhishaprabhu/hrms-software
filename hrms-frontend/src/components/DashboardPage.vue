<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card text-white bg-info mb-3">
          <div class="card-header">HRMS Dashboard</div>
          <div class="card-body">
            <h5 class="card-title">Total Employees</h5>
            <p class="card-text fs-3">{{ totalEmployees }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from 'axios';

export default {
  name: 'DashboardPage',
  data() {
    return {
      totalEmployees: 0
    };
  },
  mounted() {
    this.getTotalEmployees();
  },
  methods: {
    async getTotalEmployees() {
      try {
        const response = await axios.get('http://localhost:8000/api/total-employees');
        this.totalEmployees = response.data.total_employees;
      } catch (error) {
        console.error("Error fetching employee count:", error);
      }
    }
  }
};
</script>
<style scoped>
.card {
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
</style>
