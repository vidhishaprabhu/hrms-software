<template>
<div></div>
  
</template>
<script>
import api from '../api';
export default {
  name: 'EmployeeDashboard',
  data(){
    return{
      employeeData:{},
      userData: {}
    }

  },
  mounted(){
    this.fetchEmployeeData();
    this.getUser();
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
    async getUser(){
      try {
        const response = await api.get('/user');
        this.userData = response.data;
      } catch (error) {
        console.error('Error fetching user data:', error);
      }
    }
  },
 
  
};
</script>
