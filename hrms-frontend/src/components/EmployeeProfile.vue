<template>
  <div class="center-container">
    <h3 class="page-title">Employee Profile</h3>
    <img :src="require('@/assets/profile.png')" alt="Profile" class="profile-image" />
    <p class="employee-name">{{ first_name }}</p>
    <button class="btn">Upload Image</button>
    <div class="wrapper mt-8 ">
    <div class="profile-container">
      <!-- Sidebar -->
      <div class="sidebar">
        <ul>
          <li :class="{ active: activeTab === 'basic' }" @click="activeTab = 'basic'">Basic Details</li>
          <li :class="{ active: activeTab === 'position' }" @click="activeTab = 'position'">Position Details</li>
          <li :class="{ active: activeTab === 'identity' }" @click="activeTab = 'identity'">Identity (PAN/Adhaar/Insurance)</li>
          <li :class="{ active: activeTab === 'payment' }" @click="activeTab = 'payment'">Payment Details</li>
          <li :class="{ active: activeTab === 'documents' }" @click="activeTab = 'documents'">Documents</li>
          <li :class="{ active: activeTab === 'leave balance' }" @click="activeTab = 'leave balance'">Leave Balance</li>
          <li :class="{ active: activeTab === 'salary details' }" @click="activeTab = 'salary details'">Salary Details</li>
        </ul>
      </div>

      <!-- Content -->
      <div class="content">
  <!-- Basic Info -->
  <div v-if="activeTab === 'basic'">
    <div class="section-header">
      <IdcardOutlined />
      <h3>Basic Information</h3>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Employee Code:</strong></div>
      <div class="col-8">{{ emp_id }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>First Name:</strong></div>
      <div class="col-8">{{ first_name }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Gender:</strong></div>
      <div class="col-8">{{ gender }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Blood Group:</strong></div>
      <div class="col-8">{{blood_group}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Father Name:</strong></div>
      <div class="col-8">{{father_name}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Date of Birth:</strong></div>
      <div class="col-8">{{date_of_birth}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Marital Status:</strong></div>
      <div class="col-8">{{marital_status}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Physically Challenged:</strong></div>
      <div class="col-8">{{physically_challenged}}</div>
    </div>
  </div>

  <!-- Contact Info -->
  <div v-if="activeTab === 'basic'">
    <div class="section-header mt-4">
      <ContactsOutlined />
      <h3>Contact Details</h3>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Phone No:</strong></div>
      <div class="col-8">{{ phone_number }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Email:</strong></div>
      <div class="col-8">{{ email }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>City/Town:</strong></div>
      <div class="col-8">{{city}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>State:</strong></div>
      <div class="col-8">{{state}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Pin:</strong></div>
      <div class="col-8">{{pin}}</div>
    </div>
  </div>

  <!-- Joining Info -->
  <div v-if="activeTab === 'basic'">
    <div class="section-header mt-4">
      <i class="mdi mdi-walk"></i>
      <h3>Joining Details</h3>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Date of Joining:</strong></div>
      <div class="col-8">{{date_of_joining}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Confirmation Date:</strong></div>
      <div class="col-8">{{confirmation_date}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Employee Type:</strong></div>
      <div class="col-8">{{employee_type}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Probation Period (days):</strong></div>
      <div class="col-8">{{probation_period_days}}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Status:</strong></div>
      <div class="col-8">{{ status }}</div>
    </div>
  </div>

  <!-- Position -->
  <div v-if="activeTab === 'position'">
    <div class="section-header">
      <TeamOutlined />
      <h3>Position Details</h3>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Department:</strong></div>
      <div class="col-8">{{ department }}</div>
    </div>
    <div class="row mb-2">
      <div class="col-4"><strong>Designation:</strong></div>
      <div class="col-8">{{ designation }}</div>
    </div>
  </div>

  <!-- Identity -->
  <div v-if="activeTab === 'identity'">
    <div class="section-header">
      <CreditCardOutlined />
      <h3>Identity Details</h3>
    </div>
    <p>PAN, Adhaar, Insurance info goes here...</p>
  </div>

  <!-- Payment -->
  <div v-if="activeTab === 'payment'">
    <div class="section-header">
      <DollarOutlined />
      <h3>Payment Details</h3>
    </div>
    <p>Salary, bank account info goes here...</p>
  </div>

  <!-- Documents -->
  <div v-if="activeTab === 'documents'">
    <div class="section-header">
      <FileOutlined />
      <h3>Documents</h3>
    </div>
    <p>Upload/view documents here...</p>
  </div>

  <!-- Leave Balance -->
  <div v-if="activeTab === 'leave balance'">
    <div class="section-header">
      <CalendarOutlined />
      <h3>Leave Balance</h3>
    </div>
    <table class="table">
      <thead>
        <tr>
          <th>Leave Type</th>
          <th>Balance</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Bereavement Leave</td>
          <td>{{ leaveBalanceData.bereavement_leave }}</td>
        </tr>
        <tr>
          <td>Annual Leave</td>
          <td>{{ leaveBalanceData.annual_leave }}</td>
        </tr>
        <tr>
          <td>Restricted Leave</td>
          <td>{{ leaveBalanceData.restricted_holiday }}</td>
        </tr>
        <tr>
          <td>Work From Home</td>
          <td>{{ leaveBalanceData.work_from_home }}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Salary -->
  <div v-if="activeTab === 'salary details'">
    <div class="section-header">
      <WalletOutlined />
      <h3>Salary Details</h3>
    </div>
    <p>Salary, allowances, deductions info goes here...</p>
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
      phone_number:'',
      department:'',
      designation:'',
      date_of_joining:'',
      blood_group:'',
      city:'',
      address:'',
      gender:'',
      father_name:'',
      date_of_birth:'',
      marital_status:'',
      physically_challenged:'',
      state:'',
      pin:'',
      confirmation_date:'',
      employee_type:'',
      probation_period_days:'',
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
        this.status=response.data.status,
        this.phone_number=response.data.phone_number,
        this.department=response.data.department,
        this.designation=response.data.designation,
        this.date_of_joining=response.data.date_of_joining,
        this.blood_group=response.data.blood_group,
        this.city=response.data.city,
        this.address=response.data.address,
        this.gender=response.data.gender,
        this.father_name=response.data.father_name,
        this.date_of_birth=response.data.date_of_birth,
        this.marital_status=response.data.marital_status,
        this.physically_challenged=response.data.physically_challenged,
        this.state=response.data.state,
        this.pin=response.data.pin,
        this.confirmation_date=response.data.confirmation_date,
        this.employee_type=response.data.employee_type,
        this.probation_period_days=response.data.probation_period_days
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
/* Page Header */
.center-container {
  text-align: center;
  margin-bottom: 20px;
}

.page-title {
  font-size: 29px;
  font-weight: 600;
  margin-bottom: 10px;
}

.profile-image {
  width: 200px;
  height: 200px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 10px;
  border: 2px solid #1890ff;
}

.employee-name {
  font-size: 30px;
  font-weight: 500;
  margin-bottom: 10px;
}

.btn {
  padding: 6px 16px;
  background:#00B4D8;
  color: #fff;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.3s;
}
/* Layout */
.wrapper {
  display: flex;
  justify-content: center; /* centers horizontally */
  align-items: center;     /* centers vertically */
  margin-top: 40px;
  min-height: calc(100vh - 120px); /* ensures vertical centering */
}

.profile-container {
  display: flex;
  width: 95%;
  max-width: 1300px;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 14px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  min-height: 500px;
  margin-left:auto;
  margin-bottom:200px
}

/* Sidebar */
.sidebar {
  width: 250px;
  background: #f7f9fc;
  padding: 20px 0;
  border-right: 1px solid #eee;
}

.sidebar ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.sidebar ul li {
  padding: 12px 20px;
  cursor: pointer;
  font-size: 15px;
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s;
  border-left: 4px solid transparent;
}

.sidebar ul li:hover {
  background: #f0f5ff;
  color: #0077B6;
}

.sidebar ul li.active {
  background: #e6f4ff;
  color: #0077B6;
  font-weight: 600;
  border-left: 4px solid #0077B6;
}

/* Content */
.content {
  flex: 1;
  padding: 25px;
  font-size: 15px;
}

.section-header {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 18px 0 12px;
  border-bottom: 1px solid #f0f0f0;
  padding-bottom: 6px;
}

.section-header h3 {
  margin: 0;
  font-size: 17px;
  font-weight: 600;
  color: #333;
}

/* Tables */
.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 12px;
}

.table th, .table td {
  padding: 12px;
  text-align: left;
  border: 1px solid #eee;
}

.table th {
  background: #fafafa;
  font-weight: 600;
}

/* Responsive */
@media (max-width: 900px) {
  .profile-container {
    flex-direction: column;
  }
  .sidebar {
    width: 100%;
    border-right: none;
    border-bottom: 1px solid #eee;
  }
}
</style>
