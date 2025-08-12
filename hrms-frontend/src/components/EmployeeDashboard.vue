<template>
<div class="container mt-4 d-flex justify-content-center">
  <div class="row g-4" style="max-width: 1200px; width: 100%;margin-left: 10%;">

    <!-- Sign In Card -->
    <div class="col-md-4">
      <div class="card shadow-sm rounded-4 text-center p-3 h-100" style="margin-left: 20px;">
        <h5>Employee Sign In</h5>
        <h2 class="fw-bold">{{ currentTime }}</h2>

        <button
  class="btn btn-primary my-2 d-flex align-items-center justify-content-center mx-auto"
  @click="isSignedIn ? signOut() : showModal = true"
>
  <i class="bi bi-fingerprint me-2"></i>
  {{ isSignedIn ? 'Sign Out' : 'Sign In' }}
</button>

        <div class="modal fade" :class="{ show: showModal }" style="display: block;" v-if="showModal">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

              <!-- Header -->
              <div class="modal-header text-white" style="background-color: #0077B6;">
                <h5 class="modal-title">Attendance Mark</h5>
                <button type="button" class="btn-close" @click="closeModal"></button>
              </div>

              <!-- Body -->
              <div class="modal-body">
                <!-- Location Dropdown -->
                <div class="mb-3">
                  <label class="form-label">Enter sign in location<span class="text-danger">*</span></label>
                  <select class="form-select" v-model="location">
                    <option value="" disabled>Select</option>
                    <option value="Work from Home">Work from Home</option>
                    <option value="Office">Office</option>
                  </select>
                </div>

                <!-- Remark -->
                <div class="mb-3">
                  <label class="form-label">Remark</label>
                  <textarea class="form-control" placeholder="Reason" v-model="remark"></textarea>
                </div>
              </div>

              <!-- Footer -->
              <div class="modal-footer">
                <button class="btn btn-light" @click="closeModal">Cancel</button>

                <!-- Toggle between Sign In and Sign Out -->
               <button @click="isSignedIn ? signOut() : checkIn()" class="btn">
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
                <a v-if="!holiday.applied" href="#" class="text-primary" @click.prevent="openForm(holiday)">
                  Apply
                </a>
                <span v-else class="text-success">Applied</span>
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
      isSignedIn: false,
      checkin: null,
      employeeId: '',
      showModal: false,
      // signedIn: localStorage.getItem('signedIn') === 'true',
      attendanceId: null,
      location: '',
      remark: '',
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
    
  //   formattedCheckIn() {
  //   const checkIn = this.attendanceData.check_in;

  //   // If no check_in value, show placeholder
  //   if (!checkIn) return '--:--';

  //   // Try to convert to Date object
  //   const date = new Date(checkIn);

  //   // If date is invalid, show placeholder
  //   if (isNaN(date.getTime())) return '--:--';

  //   // Format date to hh:mm AM/PM
  //   return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });
  // },
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
  
  if (this.userData.id) {
    const storedCheckIn = localStorage.getItem(`checkInTime_${this.userData.id}`);
    if (storedCheckIn) {
      this.checkin = storedCheckIn;
      this.isSignedIn = true;
    }
  }
    this.fetchEmployeeData();
    this.startClock();
    this.generateCalendar();
    this.fetchHolidays();
  },
  created() {
    this.signedIn = localStorage.getItem('signedIn') === 'true';
    this.checkInTime = localStorage.getItem('checkInTime');
    this.attendanceId = localStorage.getItem('attendanceId');
    this.employeeId = localStorage.getItem('employeeId');
  },
  methods: {
//     async fetchCheckIn() {
//   try {
//     const response = await api.get('/attendance');
//     this.checkin= response.data.checkInTime; 
//     } catch (error) {
//     console.error('Error fetching check-in time:', error);
//     this.checkin = '--:--';
//   }
// },

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




    async submitSignOut() {
      try {
        const checkOutTime = new Date();
        this.signOutTime = new Date().toLocaleTimeString('en-US', {
          hour12: true
        });

        const payload = {
          check_in: this.checkInTime,
          check_out: checkOutTime
        };

        await api.put(`/attendance/${this.attendanceId}`, payload);

        // Clear local state
        this.signedIn = false;
        this.checkInTime = null;
        this.attendanceId = null;
        localStorage.removeItem('signedIn');
        localStorage.removeItem('checkInTime');
        localStorage.removeItem('attendanceId');

        this.closeModal();
      } catch (error) {
        console.error('Sign out error:', error);
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
      this.updateTime();
      setInterval(this.updateTime, 1000);
    },
    updateTime() {
  const now = new Date();
  this.currentTime = now.toLocaleTimeString('en-IN', {
    hour12: true,
    timeZone: 'Asia/Kolkata',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
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
   async signOut() {
  try {
    if (!this.userData?.id) {
      alert("User ID not found. Please log in again.");
      return;
    }
    const response = await api.put(`/attendance/signout/${this.userData.id}`);

    this.signOutTime = response.data.check_out_time;
    this.isSignedIn = false;

    // Clear any local check-in storage
    // localStorage.removeItem(`checkInTime_${this.userData.id}`);

    alert('Sign out successful');
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
