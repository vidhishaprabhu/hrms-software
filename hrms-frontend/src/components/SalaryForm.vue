<template>
  <div class="container mt-4">
    <h3 class="text-center">Update Salary Details</h3>
    <form @submit.prevent="updateSalary">
      <div class="mb-3">
        <label class="form-label">Select Employee</label>
        <select class="form-control mb-3" v-model="form.employee_id" required>
          <option value="" disabled>Select Employee</option>
          <option v-for="emp in employees" :key="emp.id" :value="emp.id">
          {{ emp.employee_id }}
          </option>
        </select>
      </div>


      <div class="mb-3">
        <label class="form-label">Employee Type</label>
        <select v-model="form.employee_type" class="form-select" required>
          <option disabled value="">Select Type</option>
          <option value="Permanent">Permanent</option>
          <option value="Probation">Probation</option>
          <option value="Intern">Intern</option>
        </select>
      </div>

      <div v-if="form.employee_type === 'Permanent'">
        <div class="mb-3">
          <label class="form-label">Salary</label>
          <input
            type="number"
            v-model="form.salary"
            class="form-control"
            min="0"
            placeholder="Enter monthly salary"
          />
        </div>
        <div class="mb-3">
          <label class="form-label">Bonus</label>
          <input
            type="number"
            v-model="form.bonus"
            class="form-control"
            min="0"
            placeholder="Enter bonus"
          />
        </div>
      </div>

      <!-- Hourly Rate (Probation or Intern) -->
      <div v-if="form.employee_type === 'Probation' || form.employee_type === 'Intern'">
        <div class="mb-3">
          <label class="form-label">Stipend</label>
          <input
            type="number"
            v-model="form.hourly_rate"
            class="form-control"
            min="0"
            placeholder="Enter hourly rate"
          />
        </div>
      </div>

      <!-- Submit -->
      <button type="submit" class="btn">Update</button>
    </form>

    <!-- Success/Error Messages -->
    <div v-if="message" class="alert alert-info mt-3">{{ message }}</div>
  </div>
</template>

<script>
import api from "../api";

export default {
  name: "SalaryForm",
  props: {
    employeeId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      employees : [],
      form: {
        employee_id: "",
        employee_type: "",
        salary: null,
        hourly_rate: null,
        bonus: null,
      },
      message: "",
    };
  },
  mounted(){
    this.fetchEmployees();

  },
  methods: {
    resetForm(){
      this.form = {
        employee_id: "",
        employee_type: "",
        salary: null,
        hourly_rate: null,
        bonus: null,
      };
      this.message = "";
    },
    async fetchEmployees() {
      try {
        const response = await api.get("/employees");
        this.employees = response.data; 
      } catch (error) {
        console.error("Error fetching employees:", error);
      }
    },
    async updateSalary() {
      try {
        await api.put(`/update-salary/${this.form.employee_id}`, this.form);
        alert("Employee compensation updated successfully!");
        this.resetForm();
      } catch (error) {
        console.error("Error updating salary:", error);
        this.message = "Failed to update employee compensation.";
      }
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
}
.btn {
  background-color: #0077B6;
  color: white;
  width: 100%;
}
</style>
