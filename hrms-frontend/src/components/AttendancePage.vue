<template>
  <div class="container mt-4">
    <h5 class="text-center mb-4" style="color:#0077B6; font-weight:600;">
      Attendance Summary
    </h5>

    <!-- Center the table properly -->
    <div class="d-flex justify-content-center">
      <div class="table-responsive" style="max-width: 350%;margin-left: 150px;" v-if="attendanceData.length > 0">
      <div class="text-end mb-3">
        
        <button @click="exportAttendanceToCSV" class="btn" style="background-color:#0077B6;color:white">
          Export
        </button>
      </div>
      <div class="d-flex justify-content-end mb-3 gap-2">
  <input
    type="text"
    class="form-control"
    placeholder="Search by name, ID, email..."
    v-model="searchQuery"
    style="max-width: 300px;"
  />
  <button class="btn" @click="applySearch">Search</button>
  <button class="btn" @click="resetSearch">Reset</button>
</div>


        <table class="table table-bordered text-center">
          <thead class="thead-dark">
            <tr>
              <th>Sl No</th>
              <th>Employee ID</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Department</th>
              <th>Designation</th>
              <th>Date of Joining</th>
              <th>Gender</th>
              <th>Attendance Date</th>
              <th>Check In</th>
              <th>Check Out</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="record in filteredAttendanceData" :key="record.id">
              <td>{{ record.id }}</td>
              <td>{{ record.employee?.employee_id ?? '-' }}</td>
              <td>{{ record.employee?.first_name ?? '-' }}</td>
              <td>{{ record.employee?.last_name ?? '-' }}</td>
              <td>{{ record.employee?.email ?? '-' }}</td>
              <td>{{ record.employee?.phone_number ?? '-' }}</td>
              <td>{{ record.employee?.department ?? '-' }}</td>
              <td>{{ record.employee?.designation ?? '-' }}</td>
              <td>{{ record.employee?.date_of_joining ?? '-' }}</td>
              <td>{{ record.employee?.gender ?? '-' }}</td>
              <td>{{ record.attendance_date }}</td>
              <td>{{ record.check_in }}</td>
              <td>{{ record.check_out }}</td>
              <td>{{ record.status }}</td>
              <td><button style="border:none;background-color:red;color:white" @click="deleteAttendanceRecord(record.id)"><DeleteOutlined/></button></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div v-if="attendanceData.length === 0" class="text-center text-danger">
        <p>No attendance records found.</p>
      </div>
    </div>
  </div>
</template>


<script>
import axios from 'axios';
import {
  DeleteOutlined,
} from '@ant-design/icons-vue';
export default{
  name:'AttendancePage',
  components: {
    DeleteOutlined
  },
  data(){
    return{
      attendancePresentData: '',
      searchQuery: '',
      filteredAttendanceData: [],
      attendanceAbsentData: '',
      attendanceLateData: '',
      checkinData:'',
      checkoutData:'',
      attendanceData: []
    }
    
  },
  mounted(){
    this.attendanceSummaryOfData();

  },
  methods:{
    applySearch() {
    const query = this.searchQuery.toLowerCase();

    this.filteredAttendanceData = this.attendanceData.filter(record => {
      const emp = record.employee ?? {};
      return (
        String(emp.employee_id ?? '').toLowerCase().includes(query) ||
        String(emp.first_name ?? '').toLowerCase().includes(query) ||
        String(emp.last_name ?? '').toLowerCase().includes(query) ||
        String(emp.email ?? '').toLowerCase().includes(query)
      );
    });
  },
  resetSearch() {
    this.searchQuery = '';
    this.filteredAttendanceData = this.attendanceData;
  },
  exportAttendanceToCSV() {
    const header = [
      "Sl No",
      "Employee ID",
      "First Name",
      "Last Name",
      "Email",
      "Phone Number",
      "Department",
      "Designation",
      "Date of Joining",
      "Gender",
      "Attendance Date",
      "Check In",
      "Check Out",
      "Status"
    ];

    let csv = header.join(",") + "\n";

    this.attendanceData.forEach((record) => {
      const row = [
        record.id,
        record.employee?.employee_id ?? '-',
        record.employee?.first_name ?? '-',
        record.employee?.last_name ?? '-',
        record.employee?.email ?? '-',
        record.employee?.phone_number ?? '-',
        record.employee?.department ?? '-',
        record.employee?.designation ?? '-',
        record.employee?.date_of_joining ?? '-',
        record.employee?.gender ?? '-',
        record.attendance_date ?? '-',
        record.check_in ?? '-',
        record.check_out ?? '-',
        record.status ?? '-'
      ];
      csv += row.join(",") + "\n";
    });

    // Create blob and trigger download
    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    const url = URL.createObjectURL(blob);
    link.setAttribute("href", url);
    link.setAttribute("download", "Attendance_Summary.csv");
    link.style.visibility = "hidden";
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  },
    async attendanceSummaryOfData() {
      try {
        const response = await axios.get('http://localhost:8000/api/attendance');
        this.attendanceData = response.data;
        this.filteredAttendanceData = response.data;
      } catch (error) {
        console.error("Error fetching attendance data:", error);
      }
    },
    async deleteAttendanceRecord(id) {
      try {
        await axios.delete(`http://localhost:8000/api/attendance/${id}`);
        this.attendanceData = this.attendanceData.filter(record => record.id !== id);
      } catch (error) {
        console.error("Error deleting attendance record:", error);
      }
    }
  }
}
</script>
<style scoped>
.btn{
  background-color: #0077B6;
  color: white;
  border: none;
}
</style>
