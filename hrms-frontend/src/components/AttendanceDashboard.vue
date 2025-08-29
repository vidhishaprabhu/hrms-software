<template>
<div class="container mt-5">
  <div class="row justify-content-center">
    <!-- Total Employees -->
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Today's Attendances</div>
        <div class="card-body">
          <p class="card-text fs-3">{{attendanceCount}} %</p>
        </div>
      </div>
    </div>
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">On Time</div>
        <div class="card-body">
          <p class="card-text fs-3">0</p>
        </div>
      </div>
    </div>
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Late come</div>
        <div class="card-body">
          <p class="card-text fs-3">0</p>
        </div>
      </div>
    </div>
    </div>
  
    
    



</div>
</template>

<script>
import api from '../api';
export default{
  name:'AttendanceDashboard',
  data(){
    return{
      attendanceCount:0
    }
  },
  mounted(){
    this.getAttendanceCount();

  },
  methods:{
    async getAttendanceCount(){
      try{
        const response=await api.get('/attendance-percentage');
        this.attendanceCount=response.data.attendance_percentage;

      }
      catch(error){
        console.error('Error in fetching the attendance percentage data');
      }
    }
  }
}
</script>
