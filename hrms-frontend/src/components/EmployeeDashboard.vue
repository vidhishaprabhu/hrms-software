<template>
<div class="container mt-4 d-flex justify-content-center">
  <div class="row g-4" style="max-width: 1200px; width: 100%;margin-left: 10%;">

    <!-- Sign In Card -->
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 text-center p-3 h-100 " style="margin-left: 20px;">
        <div style="display: flex; align-items: center;">
  <h5>Employee Sign In</h5>
  <i class="bi bi-box-arrow-in-right" 
     style="font-size: 2.2rem; color: #00B4D8; margin-left: auto;"></i>
</div>

        <h2 class="fw-bold">{{ currentTime }}</h2>

        <button
  class="btn my-2 d-flex align-items-center justify-content-center mx-auto"
  @click="showModal=true" style="background-color: #00B4D8; color: white;width:65%"
>
  <i class="bi bi-fingerprint me-2"></i>
  {{ isSignedIn ? 'Sign Out' : 'Sign In' }}
</button>

        <div class="modal fade" :class="{ show: showModal }" style="display: block;" v-if="showModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Header -->
              <div class="modal-header text-white" style="background-color: #00B4D8;">
                <h5 class="modal-title" style="color:white">Attendance Mark</h5>
                <button type="button" class="btn-close" @click="closeModal" style="color:white;background-color:white"></button>
              </div>
              <div class="modal-body">
                <div class="mb-3">
                  <label class="form-label">Enter sign in location<span class="text-danger">*</span></label>
                  <select class="form-select" v-model="location">
                    <option value="" disabled>Select</option>
                    <option value="Work from Home">Work from Home</option>
                    <option value="Office">Office</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label class="form-label">Remark</label>
                  <textarea class="form-control" placeholder="Reason" v-model="remark"></textarea>
                </div>
              </div>

              <!-- Footer -->
              <div class="modal-footer">
                <button class="btn btn-light" @click="closeModal">Cancel</button>

                <!-- Toggle between Sign In and Sign Out -->
               <button @click="isSignedIn ? signOut() : checkIn()" class="btn" style="background-color:#00B4D8; color: white;"
>
                {{ isSignedIn ? 'Sign Out' : 'Sign In' }}
              </button>
              </div>

            </div>
          </div>
        </div>

        <div class="text-start mt-3 px-2">
          <p><strong>Sign In</strong> :
            <span>{{checkin}}</span>
          </p>

          <p><strong>Sign Out</strong> :
          <span>{{signOutTime}}</span>
          </p>
        </div>

        <div class="text-end pe-2 text-muted">{{ currentDate }}</div>
      </div>
    </div>

    <!-- Holiday Card -->
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 p-3 h-100">
        <h5 class="mb-3">Upcoming Holiday</h5>
        <div style="max-height: 200px; overflow-y: auto;">
          <div v-for="(holiday, index) in holidaysThisMonth" :key="index" class="d-flex justify-content-between mb-2">
            <span :class="{ 'fw-bold': index === 0 }">{{ holiday.title }}</span>
            <span>
              <template v-if="holiday.type === 'Restricted'">
                <a v-if="!holiday.applied" href="#" style="color:#00B4D8">
                  Apply
                </a>
                <!-- <span v-else class="text-success">Applied</span> -->
              </template>
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
      <div class="d-flex justify-content-between align-items-center mb-3">
        <button @click="prevMonth" style="border:none; background:none; padding:0; cursor:pointer;"><LeftOutlined style="font-size: 20px; color: black;" /></button>
        <h4>{{ new Date(currentYear, currentMonth).toLocaleString('default', { month: 'long', year: 'numeric' }) }}</h4>
        <button @click="nextMonth" style="border:none; background:none; padding:0; cursor:pointer;">
          <RightOutlined style="font-size: 20px; color: black;" />
        </button>
      </div>
      <table class="table table-bordered calendar-table">
        <thead>
          <tr>
            <th v-for="day in ['S','M','T','W','T','F','S']" :key="day">{{ day }}</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(week, wIndex) in calendar" :key="wIndex">
            <td v-for="(day, dIndex) in week" :key="dIndex">
              <span :class="day.class" :title="day.title">{{ day.date }}</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    <div class="col-md-4">
  <div class="card shadow-sm rounded-4 p-3 text-center custom-card mb-6 h-100">
    <h5 class="text-center">Attendance Monthly</h5>
    <i class="bi bi-calendar-event-fill"></i>
    <div class="card-body">
      <div class="leave-item">
        <span class="leave-name" style="font-size:13px">Present</span>
        <div class="leave-right">
          <span class="leave-days">{{presentDays}}</span>
        </div>
      </div>
      <div class="leave-item">
        <span class="leave-name" style="font-size:13px">Absent</span>
        <div class="leave-right">
          <span class="leave-days">{{absentDays}}</span>
        </div>
      </div>
      <div class="leave-item">
        <span class="leave-name" style="font-size:13px">Leave</span>
        <div class="leave-right">
          <span class="leave-days">{{leaveCount}}</span>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-md-4 d-flex">
  <div class="card shadow-sm rounded-4 p-3 text-center mb-4 leave-card w-100">
    <h5 class="mb-3">Leave Balance</h5>
    <i class="bi bi-calendar-check-fill fs-3" style="color:#00B4D8"></i>
    <div class="card-body">
      
      <div class="leave-item">
        <span class="leave-name">Bereavement Leave</span>
        <div class="leave-right">
          <span class="leave-days">{{ leaveBalanceData?.bereavement_leave }}</span>
          <router-link 
            :to="{ name: 'apply-leave', params: { type: 'bereavement' } }" 
            class="apply-link">
            Apply
          </router-link>
        </div>
      </div>

      <div class="leave-item">
        <span class="leave-name">Annual Leave</span>
        <div class="leave-right">
          <span class="leave-days">{{ leaveBalanceData?.annual_leave }}</span>
          <router-link 
            :to="{ name: 'apply-leave', params: { type: 'annual' } }" 
            class="apply-link">
            Apply
          </router-link>
        </div>
      </div>

      <div class="leave-item">
        <span class="leave-name">Restricted Holiday</span>
        <div class="leave-right">
          <span class="leave-days">{{ leaveBalanceData?.restricted_holiday }}</span>
          <router-link 
            :to="{ name: 'apply-leave', params: { type: 'restricted_holiday' } }" 
            class="apply-link">
            Apply
          </router-link>
        </div>
      </div>

      <div class="leave-item">
        <span class="leave-name">Work from Home</span>
        <div class="leave-right">
          <span class="leave-days">{{ leaveBalanceData?.work_from_home }}</span>
          <router-link 
            :to="{ name: 'apply-leave', params: { type: 'work_from_home' } }" 
            class="apply-link">
            Apply
          </router-link>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="col-md-4">
  <div class="card shadow-sm rounded-4 p-3 text-center custom-card mb-6">
    <h5>Quick Access</h5>
    <div class="card-body">
      <a href="#" style="color:#00B4D8">IT Statement</a>
    </div>
  </div>
</div>
  </div>
</div>

</template>

<script>
import api from '../api';
import { RightOutlined,LeftOutlined } from '@ant-design/icons-vue';
export default {
  name: 'EmployeeDashboard',
  components: {
    RightOutlined,
    LeftOutlined
  },
  data() {
    return {
      leaveCount:'',
      employeeId: null,
      leaveBalanceData:{},
      absentDays:'',
      presentDays: '',
      workinghours: '',
      currentTime:'',
      isSignedIn: false,
      checkin: null,
      showModal: false,
      attendanceId: null,
      location: '',
      remark: '',
      formData: {
        title: '',
        date: '',
        reason: ''
      },
      currentMonth: new Date().getMonth(), // 0 = Jan
      currentYear: new Date().getFullYear(),
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
  
  async mounted() {
  await this.getUser();

  // 1. Load from localStorage for instant UI
  const storedStatus = localStorage.getItem("isSignedIn");
  this.isSignedIn = storedStatus === "true";

  if (this.userData.id) {
    this.checkin = localStorage.getItem(`checkInTime_${this.userData.id}`) || null;
    this.signOutTime = localStorage.getItem(`checkOutTime_${this.userData.id}`) || null;
  }
  await this.checkSignInStatus();
  this.getLeaveCounts();
  this.fetchLeaveBalance();
  this.fetchEmployeeData();
  this.startClock();
  this.generateCalendar();
  this.fetchHolidays();
  this.fetchAttendanceSummary();
},
  beforeUnmount() {
  clearInterval(this.timer); // prevent memory leaks
},
  created() {
    this.signedIn = localStorage.getItem('signedIn') === 'true';
    this.checkInTime = localStorage.getItem('checkInTime');
    this.attendanceId = localStorage.getItem('attendanceId');
    this.employeeId = localStorage.getItem('employeeId');
  },
  methods: {
    async getLeaveCounts() {
      try {
        const response = await api.get("/leave-count");
        this.leaveCount=response.data.total;
      } catch (error) {
        console.error("There is an error in fetching leave count:", error);
      }
    },
    handleSignInOut() {
      if (!this.isSignedIn) {
        // Sign In
        const now = new Date().toISOString();
        localStorage.setItem(`checkInTime_${this.userData.id}`, now);
        this.checkin = now;
        this.signOutTime = null;
        localStorage.removeItem(`checkOutTime_${this.userData.id}`);
        this.isSignedIn = true;
      } else {
        // Sign Out
        const now = new Date().toISOString();
        localStorage.setItem(`checkOutTime_${this.userData.id}`, now);
        this.signOutTime = now;
        this.isSignedIn = false;
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

async fetchAttendanceSummary() {
  try {
    const response = await api.get(`/attendance/summary/${this.userData.id}`);
    this.presentDays = response.data.presentDays;
    this.absentDays = response.data.absentDays;
  } catch (error) {
    console.error('Failed to fetch summary', error);
  }
},
async checkSignInStatus() {
    try {
      const response = await api.get('/attendance/status'); 
      this.isSignedIn = response.data.isSignedIn;
    } catch (error) {
      console.error(error);
    }
  },
async checkIn() {
  this.isLoading = true;
  this.error = null;

  try {
    const response = await api.post('/attendance', { user_id: this.userData.id });
    this.checkin = response.data.check_in_time;
    this.isSignedIn = true;
    this.showModal = false;

    // Save to localStorage using a key unique to user
    localStorage.setItem(`checkInTime_${this.userData.id}`, this.checkin);
    localStorage.setItem("isSignedIn", "true");

  } catch (err) {
    if (err.response && err.response.status === 400 && err.response.data.message) {
      this.error = err.response.data.message;
    } else {
      this.error = 'Check-in failed. Please try again.';
    }
    console.error(err);
  } finally {
    this.isLoading = false;
  }
},
    closeModal() {
      this.showModal = false;
      this.location = '';
      this.remark = '';
    },
    async submitForm() {
      try {
        const payload = {
          holiday_name: this.formData.title,
          reason: this.formData.reason,
        };

        await api.post('/apply-holiday', payload);
        const appliedHoliday = this.holidays.find(
          (h) => h.title === this.formData.title
        );
        if (appliedHoliday) {
          appliedHoliday.applied = true;
        }

        // Clear form
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
    console.log('startClock() called');
    this.updateTime();
    this.timer = setInterval(() => {
      this.updateTime();
    }, 1000);
  },
  updateTime() {
    const now = new Date();
    this.currentTime = now.toLocaleTimeString();
    console.log('tick ->', this.currentTime);
  },
    generateCalendar() {
      const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
      const firstDay = new Date(this.currentYear, this.currentMonth, 1).getDay();

      const calendar = [];
      let dayCount = 1 - firstDay;

      for (let week = 0; week < 6; week++) {
        const weekRow = [];
        for (let day = 0; day < 7; day++) {
          const isWeekend = day === 0 || day === 6; // 0 = Sunday, 6 = Saturday

          if (dayCount < 1 || dayCount > daysInMonth) {
            weekRow.push({ date: '', class: '' });
          } else {
            weekRow.push({
              date: dayCount,
              class: isWeekend ? 'weekend' : '',
              title: isWeekend ? 'Week off' : ''
            });
          }
          dayCount++;
        }
        calendar.push(weekRow);
      }
      this.calendar = calendar;
    },
  prevMonth() {
    if (this.currentMonth === 0) {
      this.currentMonth = 11;
      this.currentYear--;
    } else {
      this.currentMonth--;
    }
    this.generateCalendar();
  },

  nextMonth() {
    if (this.currentMonth === 11) {
      this.currentMonth = 0;
      this.currentYear++;
    } else {
      this.currentMonth++;
    }
    this.generateCalendar();
  },
   async signOut() {
  try {
    if (!this.userData?.id) {
      alert("User ID not found. Please log in again.");
      return;
    }

    const response = await api.put(`/attendance/signout/${this.userData.id}`);

    this.signOutTime = response.data.check_out_time;
    this.isSignedIn = false;
    this.showModal = false;

    localStorage.setItem(`checkOutTime_${this.userData.id}`, this.signOutTime);
    localStorage.setItem("isSignedIn", "false");
    this.attendanceStatus = response.data.status;

    alert(`Sign out successful. Status: ${this.attendanceStatus}, Total Hours: ${response.data.total_working_time}`);
  } catch (error) {
    console.error('Sign out failed:', error.response?.data || error.message);
    alert(error.response?.data?.message || 'Sign out failed. Please try again.');
  }
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

  /* Global Card Styling */
.card {
  border: none;
  border-radius: 16px !important;
  box-shadow: 0 4px 8px rgba(0,0,0,0.08);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.card:hover {
  transform: translateY(-4px);
  box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}

.card h5 {
  font-size: 1rem;
  font-weight: 600;
  color: #333;
}

.card-body {
  padding: 0.5rem 0.75rem;
}

/* Leave Balance Section */
.leave-card {
  min-height: 280px;
}

.leave-item {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 6px 0;
  border-bottom: 1px dashed #e0e0e0;
  font-size: 14px;
}

.leave-item:last-child {
  border-bottom: none;
}

.leave-name {
  font-weight: 500;
  color: #444;
}

.leave-right {
  display: flex;
  align-items: center;
  gap: 10px;
}

.leave-days {
  font-weight: 600;
  color: #0077B6;
  font-size: 14px;
}

.apply-link {
  font-size: 13px;
  color: #0077B6;
  text-decoration: none;
  font-weight: 500;
  padding: 2px 6px;
  border-radius: 6px;
  background: #eaf6fc;
  transition: background 0.2s ease;
}

.apply-link:hover {
  background: #00B4D8;
  color: white;
}

/* Attendance card tweaks */
.custom-card .leave-item {
  font-size: 13px;
}

.custom-card i {
  font-size: 22px;
  color: #00B4D8;
  margin-bottom: 6px;
}

/* Holiday List */
.card .holiday-item {
  font-size: 14px;
  padding: 4px 0;
  border-bottom: 1px solid #f1f1f1;
}

.card .holiday-item:last-child {
  border-bottom: none;
}

/* Calendar Table */
.calendar-table {
  font-size: 13px;
  text-align: center;
}

.calendar-table th {
  background-color: #f8f9fa;
  font-weight: 600;
}

.calendar-table td {
  padding: 6px;
}

.calendar-table span {
  display: inline-block;
  width: 24px;
  height: 24px;
  line-height: 24px;
  border-radius: 50%;
}

.calendar-table .today {
  background: #0077B6;
  color: white;
  font-weight: bold;
}



</style>