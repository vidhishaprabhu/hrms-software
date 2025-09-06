<template>
<div class="d-flex justify-content-center align-items-center mb-5"> 
  <div class="card shadow-lg p-4" style="max-width: 600px; width: 100%;">
    <h3 class="mb-3 text-center">Update Employee Details</h3>
    <form @submit.prevent="saveDetails">
      <!-- Employee Selection -->
      <label class="form-label">Employee ID</label>
      <select class="form-control mb-3" v-model="form.employee_id">
        <option value="" disabled>Select Employee</option>
        <option v-for="emp in employeeData" :key="emp.id" :value="emp.id">
          {{ emp.employee_id }} - {{ emp.first_name }}
        </option>
      </select>

      <!-- Phone Number -->
      <div class="mb-3">
        <label class="form-label">Phone Number</label>
        <input type="text" class="form-control" v-model="form.phone_number" placeholder="Enter phone number" />
      </div>

      <!-- Email -->
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" v-model="form.email" placeholder="Enter email" />
      </div>

      <!-- Gender -->
      <div class="mb-3">
        <label class="form-label">Gender</label>
        <select v-model="form.gender" class="form-select">
          <option value="" disabled>Select Gender</option>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Other">Other</option>
        </select>
      </div>

      <!-- Department -->
      <div class="mb-3">
        <label class="form-label">Department</label>
        <input type="text" class="form-control" v-model="form.department" placeholder="Enter department" />
      </div>

      <!-- Designation -->
      <div class="mb-3">
        <label class="form-label">Designation</label>
        <input type="text" class="form-control" v-model="form.designation" placeholder="Enter designation" />
      </div>

      <!-- Date of Joining -->
      <div class="mb-3">
        <label class="form-label">Date of Joining</label>
        <input type="date" class="form-control" v-model="form.date_of_joining" />
      </div>
      
      <div class="mb-3">
        <label class="form-label">Father's Name</label>
        <input type="text" class="form-control" v-model="form.father_name" placeholder="Enter father's name" />
      </div>

      <div class="mb-3">
        <label class="form-label">Date of Birth</label>
        <input type="date" class="form-control" v-model="form.date_of_birth" />
      </div>

      <div class="mb-3">
        <label class="form-label">Marital Status</label>
        <select v-model="form.marital_status" class="form-select">
          <option value="" disabled>Select Status</option>
          <option value="Single">Single</option>
          <option value="Married">Married</option>
          <option value="Divorced">Divorced</option>
          <option value="Widowed">Widowed</option>
        </select>
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" v-model="form.physically_challenged" />
        <label class="form-check-label">Physically Challenged</label>
      </div>

      <div class="mb-3">
        <label class="form-label">City</label>
        <input type="text" class="form-control" v-model="form.city" placeholder="Enter city" />
      </div>

      <div class="mb-3">
        <label class="form-label">State</label>
        <input type="text" class="form-control" v-model="form.state" placeholder="Enter state" />
      </div>

      <div class="mb-3">
        <label class="form-label">Pin</label>
        <input type="text" class="form-control" v-model="form.pin" placeholder="Enter pin code" />
      </div>

      <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea class="form-control" v-model="form.address" placeholder="Enter address"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">Blood Group</label>
        <input type="text" class="form-control" v-model="form.blood_group" placeholder="Enter blood group" />
      </div>

      <div class="mb-3">
        <label class="form-label">Confirmation Date</label>
        <input type="date" class="form-control" v-model="form.confirmation_date" />
      </div>

      <!-- <div class="mb-3">
        <label class="form-label">Employee Type</label>
        <input type="text" class="form-control" v-model="form.employee_type" placeholder="Enter employee type" />
      </div> -->

      <div class="mb-3">
        <label class="form-label">Probation Period (days)</label>
        <input type="number" class="form-control" v-model="form.probation_period_days" placeholder="Enter probation period in days" />
      </div>

      <div class="text-center">
        <button type="submit" class="btn px-4">Save Details</button>
      </div>
    </form>
  </div>
</div>



</template>
<script>
import api from '../api';
export default{
  name:'EmployeeAdd',
  data(){
    return{
      employeeData:[],
      form: {
       employee_id: '',
      phone_number: '',
      email: '',
      gender: '',
      department: '',
      designation: '',
      date_of_joining: '',
      father_name: '',
      date_of_birth: '',
      marital_status: '',
      physically_challenged: false,
      city: '',
      state: '',
      pin: '',
      address: '',
      blood_group: '',
      confirmation_date: '',
      // employee_type: '',
      probation_period_days: ''
      }

    }
  },
  mounted(){
    this.fetchEmployeeData();

  },
  methods:{
     async fetchEmployeeData() {
      try {
        const response = await api.get('/employees');
        this.employeeData = response.data;
      } catch (error) {
        console.error('Error fetching employee data:', error);
      }
    },
    async saveDetails() {
      try {
        await api.put(`/employees/${this.form.employee_id}`, this.form);
        this.resetForm();
        alert("Employee details updated successfully!");
      } catch (error) {
        console.error("Error saving details:", error);
        alert("Failed to update employee details");
      }
    },
    resetForm(){
      this.form = {
    employee_id: '',
    phone_number: '',
    email: '',
    gender: '',
    department: '',
    designation: '',
    date_of_joining: ''
  };

    }
    
  }
}
</script>
<style scoped>
.btn{
  background-color:  #00B4D8;
  color: white;
}
.card {
  margin-bottom: 80px; /* pushes card away from footer */
}


</style>
