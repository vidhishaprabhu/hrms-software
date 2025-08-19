<template>
  <div class="d-flex justify-content-center align-items-start mt-4">
  <div class="card shadow p-4" style="max-width: 800px; width: 100%;">
    <h4 class="mb-4 text-center">Leave Application</h4>

    <form @submit.prevent="submitLeave" class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Name/Employee Id</label>
        <input type="text" class="form-control" :value="employeeNameId" disabled />
      </div>
      <div class="col-md-6">
        <label class="form-label">Select Leave <span style="color:red">*</span></label>
        <select v-model="leaveType" class="form-select" required>
  <option disabled value="">Select Leave</option>
  <option value="annual">Annual Leave</option>
  <option value="bereavement">Bereavement Leave</option>
  <option value="restricted_holiday">Restricted Holiday</option>
  <option value="work_from_home">Work From Home</option>
</select>

      </div>
      <div class="col-md-6">
        <label class="form-label">Available Leave <span style="color:red">*</span></label>
        <input type="text" class="form-control" :value="availableLeave" disabled />
        <small v-if="daysExceedBalance" class="text-danger">
      You have insufficient leave balance.
    </small>
      </div>
      <div class="col-md-6">
        <label class="form-label">Start Date <span style="color:red">*</span></label>
        <input type="date" v-model="startDate" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label class="form-label">End Date <span style="color:red">*</span></label>
        <input type="date" v-model="endDate" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label class="form-label">Number of Days <span style="color:red">*</span></label>
        <input type="number" class="form-control" :value="calculatedDays" disabled />
      </div>
      <div class="col-md-6">
        <label class="form-label">Reason for Leave <span style="color:red">*</span></label>
        <textarea v-model="reason" class="form-control" required></textarea>
      </div>
      <div class="col-12">
        <label class="form-label">Contact Details</label>
        <textarea v-model="contact" class="form-control"></textarea>
      </div>
      <div class="col-12 text-end">
        <button type="submit" class="btn">Apply for Leave</button>
      </div>
    </form>
  </div>
</div>

</template>
<script>
import api from '../api';
export default{
  name:'ApplyLeavePage',
  props: ["type"],
  data(){
    return{
      bereavement:'',
      employeeData: {},
      emp:{},
      employeeNameId: "", 
      leaveType: this.type || "annual",
      availableLeave: '',
      startDate: "",
      endDate: "",
      reason: "",
      contact: ""
    }
  },
  methods:{
    async fetchEmployeeData() {
      try {
        const response = await api.get('/employee-name-id');
        const emp = response.data;

        this.employeeData = emp;
        this.employeeNameId = `${emp.first_name} ${emp.employee_id}`;
      } catch (error) {
        console.error('Error fetching employee data:', error);
      }
    },
    async submitLeave() {
  try {
    const start = new Date(this.startDate);
    const end = new Date(this.endDate);
    const diffTime = end - start;
    const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

    if (diffDays > this.availableLeave) {
      alert("You have insufficient leave balance.");
      return; 
    }

    const payload = {
      start_date: this.startDate,
      end_date: this.endDate,
      reason: this.reason,
      leave_type: this.leaveType
    };

    const response = await api.post('/apply-leave', payload);

    alert(response.data.message);
    this.resetForm();
  } catch (error) {
    console.error("Error applying leave:", error.response?.data || error);
  }
},
resetForm(){
  this.startDate='',
  this.endDate='',
  this.reason='',
  this.contact=''

},
    async fetchLeaveBalance(){
  try{
    const response = await api.get('/leave-balances');
    this.leaveBalanceData = response.data.leave_balance;
    if(this.type === "bereavement"){
     this.availableLeave = this.leaveBalanceData.bereavement_leave;
    }
    else if(this.type === "annual"){
     this.availableLeave = this.leaveBalanceData.annual_leave;
    }
    else if(this.type === "restricted_holiday"){
     this.availableLeave = this.leaveBalanceData.restricted_holiday;
    }
    else if(this.type === "work_from_home"){
     this.availableLeave = this.leaveBalanceData.work_from_home;
    }
  }
  catch(error){
    console.error('Error in fetching leave balance data:', error.response?.data || error);
  }
},
  },
  
  mounted() {
    this.fetchEmployeeData();
    this.fetchLeaveBalance();
  },
  computed: {
    calculatedDays() {
      if (!this.startDate || !this.endDate) return 0;

      const start = new Date(this.startDate);
      const end = new Date(this.endDate);

      if (isNaN(start) || isNaN(end)) return 0;

      // difference in milliseconds
      const diffTime = end - start;

      // +1 because leave usually includes both start and end dates
      const diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24)) + 1;

      return diffDays > 0 ? diffDays : 0;
    },
    daysExceedBalance() {
      return this.calculatedDays > this.availableLeave;
    }
  },

}
</script>
<style scoped>
.btn{
  background-color:#0077B6;
  color:white;
}
</style>
