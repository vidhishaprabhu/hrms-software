<template>
  <div class="center-container">
    <h3 style="font-weight:600">Employee Profile</h3>
    <img :src="require('@/assets/profile.png')" alt="Profile" class="profile-image" />
    <p>{{first_name}}</p>
    <button class="btn">Upload Image</button>
  </div>
  <div class="wrapper">
    <div class="profile-container">
      <div class="sidebar">
        <ul>
          <li :class="{ active: activeTab === 'basic' }" @click="activeTab = 'basic'">Basic details</li>
          <li :class="{ active: activeTab === 'position' }" @click="activeTab = 'position'">Position details</li>
          <li :class="{ active: activeTab === 'identity' }" @click="activeTab = 'identity'">Identity(PAN/Adhaar/Insurance)</li>
          <li :class="{ active: activeTab === 'payment' }" @click="activeTab = 'payment'">Payment details</li>
          <li :class="{ active: activeTab === 'documents' }" @click="activeTab = 'documents'">Documents</li>
          <li :class="{ active: activeTab === 'leave balance' }" @click="activeTab = 'leave balance'">Leave Balance</li>
          <li :class="{ active: activeTab === 'salary details' }" @click="activeTab = 'salary details'">Salary Details</li>
        </ul>
      </div>
      <div class="content" style="width:200%">
        <div v-if="activeTab === 'basic'">
          <div style="display: flex; align-items: center;margin-bottom:20px">
            <h3 style="margin: 4px;">Basic information</h3>
            <IdcardOutlined style="font-size: 30px; margin-right:8px; color:#1890ff;" />
          </div>

          <p><strong>Employee Code:</strong> {{emp_id}}</p>
          <p><strong>First name:</strong> {{first_name}}</p>
          <p><strong>Gender:</strong></p>
          <p><strong>Blood Group:</strong> </p>
          <p><strong>Father Name:</strong></p>
          <p><strong>Date of Birth:</strong> </p>
          <p><strong>Marital Status:</strong></p>
          <p><strong>Physically Challenged:</strong></p>
        </div>
        <div v-if="activeTab === 'basic'">
           <div style="display: flex; align-items: center;margin-bottom:20px">
            <h3 style="margin: 4px;">Contact Details</h3>
            <ContactsOutlined style="font-size: 30px; margin-right:8px; color:#1890ff;" />
          </div>
          <p><strong>Phone No:</strong> {{}}</p>
          <p><strong>Email:</strong> {{}}</p>
        </div>

        <div v-if="activeTab === 'position'">
          <h3>Position details</h3>
          <p><strong>Department:</strong> {{}}</p>
          <p><strong>Designation:</strong> {{}}</p>
        </div>

        <div v-if="activeTab === 'identity'">
          <h3>Identity details</h3>
          <p>PAN, Adhaar, Insurance info goes here...</p>
        </div>

        <div v-if="activeTab === 'payment'">
          <h3>Payment details</h3>
          <p>Salary, bank account info goes here...</p>
        </div>

        <div v-if="activeTab === 'documents'">
          <h3>Documents</h3>
        </div>
        <div v-if="activeTab === 'leave balance'">
          <div class="tab-content mt-3" id="employeeTabsContent">
            <h3 class="text-center">Leave Balance</h3>
  <div class="tab-pane fade show active" id="current" role="tabpanel">
    <div class="table-responsive">
      
      <table class="table modern-table align-middle">
        <thead class="thead-light">
          <tr>
            <th>Leave type</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Bereavement Leave</td>
            <td>{{leaveBalanceData.bereavement_leave}}</td>
          </tr>
          <tr>
            <td>Annual Leave</td>
            <td>{{leaveBalanceData.annual_leave}}</td>
          </tr>
          <tr>
            <td>Restricted Leave</td>
            <td>{{leaveBalanceData.restricted_holiday}}</td>
          </tr>
          <tr>
            <td>Work From Home</td>
            <td>{{leaveBalanceData.work_from_home}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <div v-if="activeTab === 'salary details'">
          <h3>Payment details</h3>
          <p>Salary, bank account info goes here...</p>
  </div>
</div>
          
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import api from "../api";
import { IdcardOutlined,ContactsOutlined } from '@ant-design/icons-vue'
export default{
  name:'EmployeeProfile',
  data(){
    return{
      emp_id:'',
      first_name:'',
      last_name:'',
      email:'',
      status:'',
      activeTab: 'basic',
      leaveBalanceData:{}

    }
  },
  components:{
    IdcardOutlined,
    ContactsOutlined

  },
  mounted(){
    this.getEmployeeDetails();
    this.fetchLeaveBalance();
  },
  methods:{
    async getEmployeeDetails() {
      try {
        const response = await api.get("/employee-name-id");
        this.emp_id=response.data.employee_id,
        this.first_name=response.data.first_name,
        this.last_name=response.data.last_name,
        this.email=response.data.email,
        this.status=response.data.status
      } catch (error) {
        console.error("Error in fetching the employee details", error);
      }
    },
    async fetchLeaveBalance(){
  try{
    const response = await api.get('/leave-balances');
    this.leaveBalanceData = response.data.leave_balance;
  }
  catch(error){
    console.error('Error in fetching leave balance data:', error.response?.data || error);
  }
},
    

  }
}
</script>
<style scoped>
.wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh; 
  background-color: #f7f7f7;
}

.profile-container {
  display: flex;
  gap: 20px;
  background: white;
  width: 900px;       
  max-width: 100%;    
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.center-container {
  display: flex;
  flex-direction: column; 
  align-items: center;    
  gap: 10px;              
  margin-top: 20px;       
}

.profile-image {
  max-width: 200px;      
  height: auto;
}
.btn{
  background-color: #00B4D8;
  color:white
}
/* p{
  font-size:180%
} */
.profile-container {
  display: flex;
  gap: 20px;
}

.sidebar {
  width: 300px;
  border-right: 1px solid #ccc;
}

.sidebar ul {
  list-style: none;
  padding: 0;
}

.sidebar li {
  padding: 10px;
  cursor: pointer;
  color: #3498db;
}

.sidebar li.active {
  font-weight: bold;
  color: #0077B6;
}

.content {
  flex: 1;
  padding: 10px;
}
h5{
  font-weight:600
}
.modern-table {
  border-collapse: separate;
  border-spacing: 0;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  background-color: #fff;
}

.modern-table thead {
  background-color: #f8f9fa;
  font-weight: 600;
  text-transform: uppercase;
  color: #495057;
}

.modern-table tbody tr {
  transition: background 0.3s;
}

.modern-table tbody tr:hover {
  background-color: #f1f5f9;
}

.modern-table td, .modern-table th {
  padding: 12px 16px;
  border: none;
}
</style>
