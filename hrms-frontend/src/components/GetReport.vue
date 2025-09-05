<template>
  <div class="container mt-4">
  <div class="row g-4 justify-content-center">
    
    <!-- Weekly -->
    <div class="col-12 col-md-6 col-lg-5">
      <div class="card p-4 shadow-sm rounded-4 h-100">
        <h5 class="mb-3 text-center">Attendance Report (Last Week)</h5>
        <div style="height: 300px;">
          <BarChart v-if="chartData" :data="chartData" :options="chartOptions" />
        </div>
      </div>
    </div>

    <!-- Monthly -->
    <div class="col-12 col-md-6 col-lg-5">
      <div class="card p-4 shadow-sm rounded-4 h-100">
        <h5 class="mb-3 text-center">Attendance Report (Last Month)</h5>
        <div style="height: 300px;">
          <BarChart v-if="monthlyData" :data="monthlyData" :options="chartOptions" />
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
      monthlyData:null,
      yearlyData:null,
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            // ticks: { callback: (val) => val + "%" }
          }
        }
      }
    };
  },
  mounted() {
    api.get("/get-attendance-report")
      .then(res => {
        console.log("API Response:", res.data); 
        const labels = res.data.map(d => d.date);
        const percentages = res.data.map(d => d.percentage);

        this.chartData = {
          labels,
          datasets: [
            {
              label: "Attendance %",
              data: percentages,
              backgroundColor: "rgba(255, 99, 132, 0.6)",
              borderColor: "#4CAF50",
              tension: 0.3
            }
          ]
        };
      },
      )
      api.get("/get-attendance-report-monthly").then(res => {
      this.monthlyData = {
        labels: res.data.map(d => d.date),
        datasets: [
          {
            label: "Attendance %",
            data: res.data.map(d => d.percentage),
            backgroundColor: "rgba(255, 99, 132, 0.6)",
            borderColor: "#2196F3",
            tension: 0.3
          }
        ]
      };
    });
      
  }   
}
</script>
