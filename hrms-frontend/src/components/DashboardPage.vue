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
        </div>
      </div>
    </div>
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Leave Dashboard</div>
        <div class="card-body">
          <h5 class="card-title">Employees on Leave</h5>
          <p class="card-text fs-3">{{ leaves }}</p>
        </div>
      </div>
    </div>
    <div class="col-md-5" style="width:20%">
      <div class="card text-white bg-info mb-3 zoom-card">
        <div class="card-header">Approved Leave Dashboard</div>
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
        </div>

      </div>
    </div>
  </div>
</div>
</template>

<script>
import axios from 'axios';
import {
  CheckCircleFilled,
  CloseOutlined
} from '@ant-design/icons-vue';
export default {
  name: 'DashboardPage',
  components: {
    CheckCircleFilled,
    CloseOutlined
  },
  data() {
    return {
      totalEmployees: 0,
      newJoinees: '',
      leaves: 0,
      approvedLeaves: 0,
      rejectLeaves: 0,
    };
  },
  mounted() {
    this.getTotalEmployees();
    this.newTotalJoinees();
    this.totalLeaves();
    this.approvesLeaves();
    this.rejectedLeaves();
  },
  methods: {
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
</style>
