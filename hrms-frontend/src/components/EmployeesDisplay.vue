<template>
<div class="d-flex justify-content-end align-items-center mb-3">
  <div class="input-group me-2" style="width: 250px;">
    <span class="input-group-text" id="search-addon">
      <i class="fas fa-search"></i> 
    </span>
    <input
      type="text"
      class="form-control"
      placeholder="Search"
      v-model="searchQuery"
      @input="filterEmployees"
      aria-label="Search"
      aria-describedby="search-addon"
    />
  </div>
  <button class="btn mx-3">Export</button>

  <!-- Create button -->
  <router-link to="/register">
    <button class="btn btn-primary" style="width: 150px;">
      <span><PlusOutlined /> Create</span>
    </button>
  </router-link>
</div>



  <div class="row justify-content-center pb-5" style="margin-left:300px;">
    <div v-for="employee in filteredEmployees" :key="employee.employee_id" class="col-md-4 mb-3">
      <div class="card h-100 shadow-sm">
        <div class="card-body">
          <div class="d-flex align-items-center mb-2">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" 
                 alt="avatar" class="rounded-circle me-2" width="50" height="50"/>
            <div>
              <h5 class="card-title mb-0">{{ employee.first_name }} {{ employee.last_name }} ({{ employee.employee_id }})</h5>
              <small class="text-muted">{{ employee.email }}</small>
            </div>
          </div>
          <p class="mb-1" v-if="employee.designation">{{ employee.designation }} - <strong>{{ employee.department }}</strong></p>
          <p class="mb-0" v-if="employee.date_of_joining">Joined: {{ employee.date_of_joining }}</p>
          <p class="mb-0" v-if="employee.gender">Gender: {{ employee.gender }}</p>
          <p class="mb-0" v-if="employee.blood_group">Blood Group: {{ employee.blood_group }}</p>
        </div>
        <div class="card-footer text-end">
          <button class="btn btn-sm mx-2" style="background-color:red;color:white" @click="deleteDetails(employee.employee_id)">
            <i class="fas fa-trash-alt"></i>
          </button>
          <router-link to="/employee-add">
            <button class="btn btn-sm mx-2">
            <i class="fas fa-edit"></i>
          </button>
          </router-link>
        </div>
      </div>
    </div>
</div>
</template>

<script>
import api from '../api';
import {
  PlusOutlined
} from '@ant-design/icons-vue';
export default{
  name:'EmployeesDisplay',
  data(){
    return {
      employees:[],
      searchQuery: ""

    }
  },
  components:{

    PlusOutlined
  },
  mounted(){
    this.getEmployees();

  },
  computed: {
    filteredEmployees() {
      if (!this.searchQuery) return this.employees;

      const query = this.searchQuery.toLowerCase();
      return this.employees.filter(emp => {
        const fullName = `${emp.first_name} ${emp.last_name}`.toLowerCase();
        const empEmail= `${emp.email}`.toLowerCase()
        return (
          fullName.includes(query) 
          && empEmail.includes(query)
        );
      });
    },
  },
  
  methods: {
  async getEmployees() {
    try {
      const response = await api.get("/employees"); 
      this.employees = response.data;
    } catch (error) {
      console.error("Error fetching employees:", error);
    }
  },
  async deleteDetails(employee_id) {
    if (!confirm("Are you sure you want to delete this employee?")) return;

    try {
      await api.delete(`/delete-user/${employee_id}`);
      alert("Employee details deleted successfully!");

      this.employees = this.employees.filter(emp => emp.employee_id !== employee_id);
    } catch (error) {
      console.error("Error deleting employee details:", error);
      alert("Failed to delete employee details");
    }
  }
}
}
</script>
<style scoped>
.btn{
  background-color:  #00B4D8;
  color: white;
}
</style>
