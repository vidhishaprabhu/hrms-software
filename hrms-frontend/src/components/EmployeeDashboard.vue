<template>
<div class="container mt-4 d-flex justify-content-center">
  <div class="row g-4" style="max-width: 1200px; width: 100%;margin-left: 10%;">

    <!-- Sign In Card -->
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 text-center p-3 h-100" style="margin-left: 20px;">
        <h5>Employee Sign In</h5>
        <h2 class="fw-bold">{{ currentTime }}</h2>

        <button class="btn btn-primary my-2 d-flex align-items-center justify-content-center mx-auto" @click="signOut">
          <i class="bi bi-fingerprint me-2"></i> Sign Out
        </button>

        <div class="text-start mt-3 px-2">
          <p><strong>Sign In</strong> : {{ signInTime }}</p>
          <p><strong>Sign Out</strong> : {{ signOutTime }}</p>
        </div>

        <div class="text-end pe-2 text-muted">{{ currentDate }}</div>
      </div>
    </div>

    <!-- Holiday Card -->
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 p-3 h-100">
        <h5 class="mb-3">Upcoming Holiday</h5>
        <div style="max-height: 200px; overflow-y: auto;">
          <div v-for="(holiday, index) in holidaysThisMonth" :key="index" class="d-flex justify-content-between      mb-2">
            <span :class="{ 'fw-bold': index === 0 }">{{ holiday.title }}</span>
            <span>
              <a v-if="holiday.type === 'Restricted'" href="#" class="text-primary" @click.prevent="openForm(holiday)">Apply</a>
              {{ holiday.holiday_date }}
            </span>
          </div>
          <div v-if="showForm" class="card mt-3 p-3">
            <h5>Apply for Restricted Holiday</h5>
            <form @submit.prevent="submitForm">
              <div class="mb-2">
                <label>Holiday Title</label>
                <input v-model="formData.title" class="form-control" disabled />
              </div>
              <div class="mb-2">
                <label>Date</label>
                <input v-model="formData.date" class="form-control" disabled />
              </div>
              <div class="mb-2">
                <label>Reason</label>
                <textarea v-model="formData.reason" class="form-control" required></textarea>
              </div>
              <button type="submit" class="btn btn-success">Submit</button>
              <button type="button" class="btn btn-secondary ms-2" @click="showForm = false">Cancel</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 p-3 text-center h-100">
        <div class="d-flex justify-content-between align-items-center mb-2">
          <button class="btn btn-sm btn-light" disabled>&lt;</button>
          <h5 class="mb-0">{{ currentMonthYear }}</h5>
          <button class="btn btn-sm btn-light" disabled>&gt;</button>
        </div>
        <table class="table table-bordered calendar-table">
          <thead>
            <tr>
              <th v-for="day in ['S','M','T','W','T','F','S']" :key="day">{{ day }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(week, wIndex) in calendar" :key="wIndex">
              <td v-for="(day, dIndex) in week" :key="dIndex" :class="day.class">{{ day.date }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>
</template>

<script>
import api from '../api';
export default {
  name: 'EmployeeDashboard',
  data() {
    return {
      formData: {
        title: '',
        date: '',
        reason: ''
      },
      showForm: false,
      currentMonthYear: new Date().toLocaleString('default', {
        month: 'short',
        year: 'numeric'
      }),
      signInTime: '--:--',
      signOutTime: '--:--',
      employeeData: {},
      userData: {},
      calendar: [],
      holidays: []
    }

  },
  computed: {
    holidaysThisMonth() {
      const currentDate = new Date();
      const currentMonth = currentDate.getMonth(); // 0-indexed
      const currentYear = currentDate.getFullYear();

      return this.holidays.filter(h => {
        const holidayDate = new Date(h.holiday_date);
        return (
          holidayDate.getMonth() === currentMonth &&
          holidayDate.getFullYear() === currentYear
        );
      });
    }

  },
  mounted() {
    this.fetchEmployeeData();
    this.getUser();
    this.startClock();
    this.generateCalendar();
    this.fetchHolidays();
  },
  methods: {
    async submitForm() {
  try {
    const payload = {
      holiday_name: this.formData.title,
      reason: this.formData.reason
    };

    await api.post('/apply-holiday', payload);

    // Clear form and hide it
    this.formData.reason = '';
    this.showForm = false;
  } catch (error) {
    console.error('Error submitting holiday application:', error);
  }
},
    
  
    openForm(holiday) {
      this.formData.title = holiday.title;
      this.formData.date = holiday.holiday_date;
      this.formData.reason = '';
      this.showForm = true;
    },
    startClock() {
      this.updateTime();
      setInterval(this.updateTime, 1000);
    },
    updateTime() {
      const now = new Date();
      this.currentTime = now.toLocaleTimeString('en-US', {
        hour12: true
      });
    },
    generateCalendar() {
      const daysInMonth = 31;
      const firstDay = new Date(2025, 7, 1).getDay();
      const calendar = [];
      let dayCount = 1 - firstDay;
      for (let week = 0; week < 6; week++) {
        const weekRow = [];
        for (let day = 0; day < 7; day++) {
          if (dayCount < 1 || dayCount > daysInMonth) {
            weekRow.push({
              date: ''
            });
          } else {
            let className = '';
            // if ([1, 2, 4, 5, 6].includes(dayCount)) className = 'bg-success text-white rounded-circle';
            // else if ([3].includes(dayCount)) className = 'bg-warning text-dark rounded-circle';
            weekRow.push({
              date: dayCount,
              class: className
            });
          }
          dayCount++;
        }
        calendar.push(weekRow);
      }

      this.calendar = calendar;
    },
    signOut() {
      alert('Signed out!');
      this.signOutTime = new Date().toLocaleTimeString('en-US', {
        hour12: true
      });
    },

    async fetchEmployeeData() {
      try {
        const response = await api.get('/employees');
        this.employeeData = response.data;
      } catch (error) {
        console.error('Error fetching employee data:', error);
      }
    },
    async fetchHolidays() {
      try {
        const response = await api.get('/upcoming-holidays');
        this.holidays = response.data;
      } catch (error) {
        console.error("Error fetching holidays:", error);
      }
    },
    async getUser() {
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

<style scoped>
.calendar-table {
  table-layout: fixed;
  width: 100%;
  font-size: 14px;
}

.calendar-table td {
  height: 35px;
  vertical-align: middle;
}

.card {
  background-color: #ffffff;
  border-radius: 16px;
  border: none;
  border: 1px solid #0077B6;
}

.btn {
  background-color: #0077B6;
  color: white;
}
</style>
