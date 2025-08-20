<template>
  <div class="d-flex justify-content-center mt-4">
    <div class="card shadow-sm rounded-4 p-3 mb-4" style="max-width: 900px; width: 100%;">
      <div class="card-body">
        <h5 class="text-center mb-4">Employee List</h5>

        <!-- Tabs -->
        <ul class="nav nav-tabs justify-content-center">
          <li class="nav-item">
            <a class="nav-link active text-info fw-bold" href="#">Current Employee</a>
          </li>
        </ul>
        <div class="tab-content mt-3" id="employeeTabsContent">
  <div class="tab-pane fade show active" id="current" role="tabpanel">
    <div class="table-responsive">
      <button class="btn mb-3">Export To Excel</button>
      <table class="table modern-table align-middle">
        <thead class="thead-light">
          <tr>
            <th>Employee Id</th>
            <th>First Name</th>
            <th>Email</th>
            <th>Status</th>
            <th>View</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{emp_id}}</td>
            <td>{{first_name}}</td>
            <td>{{email}}</td>
            <td>{{status}}</td>
            <td>
              <router-link to="/employee-profile">
                <EyeOutlined class="eye-icon" />
              </router-link>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
      </div>
    </div>
  </div>
</template>

<script>
import api from "../api";
import {
  EyeOutlined
} from '@ant-design/icons-vue';
export default {
  name: "EmployeeInfo",
  data() {
    return {
      emp_id:'',
      first_name:'',
      last_name:'',
      email:'',
      status:''
    };
  },
  components:{
    EyeOutlined

  },
  mounted() {
    this.getEmployeeDetails();
  },
  methods: {
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
    }
  }
};
</script>

<style scoped>
.nav-tabs .nav-link.active {
  border-color: #00B4D8 #00B4D8 #fff;
  color: #00B4D8 !important;
  font-weight: bold;
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

.eye-icon {
  background-color: #00B4D8;
  color: white;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background 0.3s;
}

.eye-icon:hover {
  background-color: #0096c7;
}
.btn{
  background-color: #00B4D8; 
  color: white;
}
</style>
