<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form @submit.prevent="submitLeaveCount" class="card p-4 shadow-sm">
          <h4 class="mb-4">Allocate Leave to Employee</h4>
          <div class="mb-3">
            <label for="employee_id" class="form-label">Employee ID</label>
            <input type="text" class="form-control" id="employee_id" v-model="form.employee_id" required>
          </div>

          <!-- Leave fields -->
          <div class="mb-3">
            <label for="bereavement_leave" class="form-label">Bereavement Leave</label>
            <input type="number" class="form-control" v-model.number="form.bereavement_leave" required>
          </div>
          <div class="mb-3">
            <label for="annual_leave" class="form-label">Annual Leave</label>
            <input type="number" class="form-control" v-model.number="form.annual_leave" required>
          </div>
          <div class="mb-3">
            <label for="restricted_holiday" class="form-label">Restricted Holiday</label>
            <input type="number" class="form-control" v-model.number="form.restricted_holiday" required>
          </div>
          <div class="mb-3">
            <label for="work_from_home" class="form-label">Work From Home</label>
            <input type="number" class="form-control" v-model.number="form.work_from_home" required>
          </div>

          <button type="submit" class="btn mt-3">Add Leave Count</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../api';
export default {
  name: "AddLeave",
  data() {
    return {
      form: {
        employee_id: "",
        bereavement_leave: 0,
        annual_leave: 0,
        restricted_holiday: 0,
        work_from_home: 0
      }
    };
  },
  methods: {
    async submitLeaveCount() {
      try {
        const res = await api.post("/leaves", this.form);
        alert(res.data.message);
        this.resetForm();
      } catch (err) {
        console.error(err.response?.data || err.message);
        alert("Error submitting leave allocation!");
      }
    },
    resetForm() {
      this.form = {
        employee_id: "",
        bereavement_leave: 0,
        annual_leave: 0,
        restricted_holiday: 0,
        work_from_home: 0
      };
    }
  }
};
</script>

<style scoped>
.btn {
  background-color: #00B4D8;
  color: white;
}
</style>
