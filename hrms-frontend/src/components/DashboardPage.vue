<template>
<div class="container mt-5">
  <div class="row justify-content-center">
    <!-- Total Employees -->
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Total Employees Dashboard</div>
        <div class="card-body">
          <h5 class="card-title">Total Employees</h5>
          <p class="card-text fs-3">{{ totalEmployees }}</p>
          <button class="btn btn-primary"><EyeOutlined/> View</button>
        </div>
      </div>
    </div>

    <!-- New Joinees -->
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">New Joinees Dashboard</div>
        <div class="card-body">
          <h5 class="card-title">New Joinees</h5>
          <p class="card-text fs-3">{{ newJoinees }}</p>
           <button class="btn btn-primary"><EyeOutlined/> View</button>
        </div>
      </div>
    </div>
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Leave Dashboard</div>
        <div class="card-body">
          <h5 class="card-title">Employees on Leave</h5>
          <p class="card-text fs-3">{{ leaves }}</p>
           <router-link to="/attendance"><button class="btn btn-primary"><EyeOutlined/> View</button></router-link>
        </div>
      </div>
    </div>
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Leave Approval Dashboard</div>
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <p class="card-title m-0">
              Approved
              <CheckCircleFilled style="color: green;" />
              <span class="ms-2">{{ approvedLeaves }}</span>
            </p>
            <p class="card-title m-0">
              Rejected
              <CloseOutlined style="color: red;" />
              <span class="ms-2">{{ rejectLeaves }}</span>
            </p>
          </div>
          <button class="btn btn-primary mt-4"><EyeOutlined/> View</button>
        </div>

      </div>
    </div>
  </div>
  <h4 class="text-center" style="color:#0077B6;font-weight:600">Add Holidays</h4>
  <div class="d-flex justify-content-center mt-4">
  <table class="table table-bordered text-center w-auto">
    <thead>
      <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Description</th>
        <th colspan="2">Type</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          <input v-model="newHoliday.title" class="form-control" placeholder="Holiday Title" />
        </td>
        <td>
          <input v-model="newHoliday.holiday_date" type="date" class="form-control" />
        </td>
        <td>
          <input v-model="newHoliday.description" class="form-control" placeholder="Description" />
        </td>
        <td colspan="2">
          <select v-model="newHoliday.type" class="form-control mb-2">
            <option value="Public">Public</option>
            <option value="Restricted">Restricted</option>
          </select>
          <button @click="addHoliday" class="btn btn-primary w-100">
            <PlusOutlined/> Add Holiday
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>

   <h5 class="text-center" style="color:#0077B6;font-weight:600;">Upcoming Holidays <CalendarOutlined/></h5>
  <div class="d-flex justify-content-center mb-5">
  <table class="table table-bordered text-center w-auto mb-5">
    <thead>
      <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Description</th>
        <th>Action1</th>
        <th>Action2</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="holiday in holidays" :key="holiday.id">
        <td>
          <input
            v-if="editId === holiday.id"
            v-model="editHoliday.title"
            class="form-control"
          />
          <span v-else>{{ holiday.title }}</span>
        </td>
        <td>
          <input
            v-if="editId === holiday.id"
            v-model="editHoliday.holiday_date"
            class="form-control"
          />
          <span v-else>{{ holiday.holiday_date }}</span>
        </td>
        <td>
          <input
            v-if="editId === holiday.id"
            v-model="editHoliday.description"
            class="form-control"
          />
          <span v-else>{{ holiday.description }}</span>
        </td>
        <td>
          <button
            v-if="editId === holiday.id"
            class="btn" style="background-color:green;color:white"
            @click="saveHoliday(holiday.id)"
          >
            <SaveOutlined />
          </button>
          <button
            v-else
            class="btn btn-primary"
            @click="editHolidayRow(holiday)"
          >
            <EditOutlined /> 
          </button>
        </td>
        <td>
          <button
            class="btn"
            style="background-color:red;color:white"
            @click="deleteHolidayRecord(holiday.id)"
          >
            <DeleteOutlined />
          </button>
        </td>
      </tr>
    </tbody>
  </table>
</div>


</div>
</template>

<script>
import axios from 'axios';
import api from '../api';
import {
  CheckCircleFilled,
  CloseOutlined,
  EyeOutlined,
  CalendarOutlined,
  EditOutlined,
  DeleteOutlined,
  SaveOutlined,
  PlusOutlined
} from '@ant-design/icons-vue';
export default {
  name: 'DashboardPage',
  components: {
    CheckCircleFilled,
    CloseOutlined,
    EyeOutlined,
    CalendarOutlined,
    EditOutlined,
    DeleteOutlined,
    SaveOutlined,
    PlusOutlined
  },
  data() {
    return {
      newHoliday: {
  title: '',
  holiday_date: '',
  description: '',
  type: 'Public' // Default value
},
      totalEmployees: 0,
      newJoinees: '',
      leaves: 0,
      approvedLeaves: 0,
      rejectLeaves: 0,
      holidays:[],
      updateLeaveData:[],
      editId: null,
      editHoliday: {
      title: '',
      holiday_date: '',
      description: '',
      holidayData:[]
      }
    };
  },
  mounted() {
    this.getTotalEmployees();
    this.newTotalJoinees();
    this.totalLeaves();
    this.approvesLeaves();
    this.rejectedLeaves();
    this.fetchHolidays();
  },
  methods: {
    async addHoliday() {
  try {
    await api.post('/add-holiday', this.newHoliday);
    this.fetchHolidays(); 
    this.newHoliday = {
      title: '',
      holiday_date: '',
      description: '',
      type: 'Public'
    };
  } catch (error) {
    console.error('Error adding holiday:', error);
  }
},
    async getTotalEmployees() {
      try {
        const response = await axios.get('http://localhost:8000/api/total-employees');
        this.totalEmployees = response.data.total_employees;
      } catch (error) {
        console.error("Error fetching employee count:", error);
      }
    },
    async newTotalJoinees() {
      try {
        const response = await axios.get('http://localhost:8000/api/new-joinees');
        console.log("API response for new joinees:", response.data);
        this.newJoinees = response.data.new_joinees;
      } catch (error) {
        console.error("Error fetching new joinees count:", error);
      }
    },
    editHolidayRow(holiday) {
    this.editId = holiday.id;
    this.editHoliday = { ...holiday };
  },
  async saveHoliday(id) {
    try {
      await axios.put(`http://localhost:8000/api/holiday/${id}`, this.editHoliday);
      const index = this.holidays.findIndex(h => h.id === id);
      if (index !== -1) {
        this.holidays[index] = { ...this.editHoliday };
      }
      this.editId = null;
    } catch (error) {
      console.error('Update failed', error);
    }
  },
    async totalLeaves() {
      try {
        const response = await axios.get('http://localhost:8000/api/total-leaves');
        this.leaves = response.data.total_leaves;
      } catch (error) {
        console.error("Error fetching new joinees count:", error);
      }
    },
    async approvesLeaves() {
      try {
        const response = await axios.get('http://localhost:8000/api/approved-leaves');
        this.approvedLeaves = response.data.approved_leaves;
      } catch (error) {
        console.error("Error fetching new joinees count:", error);
      }
    },
    async rejectedLeaves() {
      try {
        const response = await axios.get('http://localhost:8000/api/rejected-leaves');
        this.rejectLeaves = response.data.rejected_leaves;
      } catch (error) {
        console.error("Error fetching new joinees count:", error);
      }
    },
    async fetchHolidays() {
      try {
        const response = await axios.get('http://localhost:8000/api/upcoming-holidays');
        this.holidays = response.data;
      } catch (error) {
        console.error("Error fetching holidays:", error);
      }
    },
    async deleteHolidayRecord(id) {
  try {
    await axios.delete(`http://localhost:8000/api/holiday/${id}`);
    this.holidays = this.holidays.filter(record => record.id !== id);
  } catch (error) {
    console.error("Error deleting holiday record:", error);
  }
}

  }
};
</script>

<style scoped>
.card {
  border-radius: 15px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.zoom-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.zoom-card:hover {
  transform: scale(1.05);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
  z-index: 2;
}
.btn{
  background-color: #00B4D8;
  color:white;
  border:none;
}
</style>
