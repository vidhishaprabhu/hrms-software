<template>
  <div class="container mt-5">
    <div class="row g-4 justify-content-center">

      <!-- Weekly Report -->
      <div class="col-12 col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4 h-100 chart-card">
          <div class="card-header text-center bg-primary text-white fw-bold rounded-top-4">
            Attendance Report (Last Week)
          </div>
          <div class="card-body p-4">
            <div class="chart-container">
              <BarChart v-if="chartData" :data="chartData" :options="chartOptions" />
            </div>
          </div>
        </div>
      </div>

      <!-- Monthly Report -->
      <div class="col-12 col-md-6 col-lg-5">
        <div class="card shadow-lg border-0 rounded-4 h-100 chart-card">
          <div class="card-header text-center bg-success text-white fw-bold rounded-top-4">
            Attendance Report (Last Month)
          </div>
          <div class="card-body p-4">
            <div class="chart-container">
              <BarChart v-if="monthlyData" :data="monthlyData" :options="chartOptions" />
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

</template>


<script>
import { Bar } from "vue-chartjs";
import {
  Chart as ChartJS,
  Title, Tooltip, Legend,
  BarElement, CategoryScale, LinearScale
} from "chart.js";
import api from '../api';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

export default {
  components: { BarChart: Bar },
  data() {
    return {
      chartData: null,
      monthlyData: null,
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: "top",
            labels: {
              font: {
                size: 13,
                family: "Segoe UI, Roboto, sans-serif",
              },
              color: "#333",
            },
          },
          tooltip: {
            backgroundColor: "#222",
            titleColor: "#fff",
            bodyColor: "#ddd",
            padding: 10,
            borderWidth: 1,
            borderColor: "#555",
          },
        },
        scales: {
          x: {
            grid: {
              drawBorder: false,
              color: "rgba(0,0,0,0.05)",
            },
            ticks: {
              font: { size: 12 },
              color: "#444",
            },
          },
          y: {
            beginAtZero: true,
            max: 100,
            grid: {
              color: "rgba(0,0,0,0.05)",
            },
            ticks: {
              callback: (val) => val + "%",
              font: { size: 12 },
              color: "#444",
            },
          },
        },
      },
    };
  },
  mounted() {
    // Weekly Attendance
    api.get("/get-attendance-report").then(res => {
      this.chartData = {
        labels: res.data.map(d => d.date),
        datasets: [
          {
            label: "Weekly Attendance %",
            data: res.data.map(d => d.percentage),
            backgroundColor: "rgba(54, 162, 235, 0.6)",   // Blue bars
            borderColor: "rgba(54, 162, 235, 1)",
            borderWidth: 1,
            borderRadius: 6, // Rounded bars
          }
        ]
      };
    });

    // Monthly Attendance
    api.get("/get-attendance-report-monthly").then(res => {
      this.monthlyData = {
        labels: res.data.map(d => d.date),
        datasets: [
          {
            label: "Monthly Attendance %",
            data: res.data.map(d => d.percentage),
            backgroundColor: "rgba(75, 192, 192, 0.6)",   // Teal bars
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 1,
            borderRadius: 6,
          }
        ]
      };
    });
  }
};
</script>

<style scoped>
.chart-card {
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.chart-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}

.card-header {
  font-size: 1.1rem;
  padding: 12px;
  letter-spacing: 0.5px;
}

.chart-container {
  height: 300px;
  position: relative;
}

.card-body {
  background: #f9fafb; /* subtle contrast for charts */
  border-radius: 0 0 1rem 1rem;
}

</style>