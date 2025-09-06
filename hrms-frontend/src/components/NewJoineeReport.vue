<template>
  <div class="container mt-4">
  <div class="row g-4 justify-content-center">
    
    <div class="col-12 col-md-6 col-lg-5">
      <div class="card p-4 shadow-sm rounded-4 h-100">
        <h5 class="mb-3 text-center">New Joinees Report (Last Month)</h5>
        <div style="height: 300px;">
          <BarChart v-if="chartData" :data="chartData" :options="chartOptions" />
        </div>
      </div>
    </div>
    <div class="col-12 col-md-6 col-lg-5">
      <div class="card p-4 shadow-sm rounded-4 h-100">
        <h5 class="mb-3 text-center">New Joinees Report (Last Week)</h5>
        <div style="height: 300px;">
          <BarChart v-if="weeklyData" :data="weeklyData" :options="chartOptions" />

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
      weeklyData:null,
      yearlyData:null,
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: { callback: (val) => val + "%" }
          }
        }
      }
    };
  },
  mounted() {
      api.get("/get-new-joinee-month")
    .then(res => {
      this.chartData = {
  labels: res.data.map(d => d.date),
  datasets: [
    {
      label: "New Joinees",
      data: res.data.map(d => d.new_joinees),
      backgroundColor: "rgba(255, 99, 132, 0.6)",
      borderColor: "rgba(255, 99, 132, 1)",
      borderWidth: 1
    }
  ]
};

    });
      api.get("/get-new-joinee-weekly")
    .then(res => {
      this.weeklyData = {
  labels: res.data.map(d => d.date),
  datasets: [
    {
      label: "New Joinees",
      data: res.data.map(d => d.new_joinees),
      backgroundColor: "rgba(255, 99, 132, 0.6)",
      borderColor: "rgba(255, 99, 132, 1)",
      borderWidth: 1
    }
  ]
};

    });
      
  }   
}
</script>

