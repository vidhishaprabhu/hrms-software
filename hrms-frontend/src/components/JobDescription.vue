<template>
<div class="d-flex justify-content-end align-items-center mb-3">
  <!-- Create button -->
  <router-link to="/create-job">
    <button class="btn btn-primary" style="width: 150px;">
      <span>
        <PlusOutlined /> Create</span>
    </button>
  </router-link>
</div>
<div class="job-list-container">
  <div class="container-fluid py-5">
    <div class="row justify-content-center">
      <div v-for="job in jobs" :key="job.id" class="col-md-8 mb-4">
        <div class="card h-100 job-card-custom shadow-sm">
          <div class="card-body">
            <div class="d-flex flex-column">
              <h5 class="card-title job-title-custom mb-2">
                {{ job.title }} (Job ID: {{ job.id }})
              </h5>
              <hr class="my-2">

              <h6 class="text-uppercase text-secondary detail-label">Department</h6>
              <p class="detail-text">{{ job.department }}</p>

              <h6 class="text-uppercase text-secondary detail-label mt-3">Responsibilities</h6>
              <p class="detail-text">{{ job.responsibilities }}</p>

              <h6 class="text-uppercase text-secondary detail-label mt-3">Qualifications</h6>
              <p class="detail-text">{{ job.qualifications }}</p>

              <!-- Action buttons aligned to the right -->
              <div class="d-flex justify-content-end gap-2 mt-3">
                <button class="btn btn-outline-secondary" @click="editJob(job)">
                  <EditOutlined /> Edit
                </button>
                <button class="btn btn-outline-primary" @click="downloadPDF(job)">
                  <DownloadOutlined /> Download PDF
                </button>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<div
  v-if="showEditForm"
  class="fixed inset-0 flex items-center justify-center z-50 modal-overlay"
>
  <div class="modal-container bg-white rounded-lg shadow-lg relative p-6">
    
    <div class="flex justify-between items-center mb-4">
      <h3 class="text-xl font-bold text-gray-800">Edit Job</h3>
      <button class="btn-close" @click="closeEditForm"></button>
    </div>

    <div class="modal-body space-y-3 overflow-auto">
      <input
        type="text"
        v-model="selectedJob.title"
        class="form-control"
        placeholder="Job Title" style="margin-bottom:10px"
      />
      <input
        type="text"
        v-model="selectedJob.department"
        class="form-control"
        placeholder="Department" style="margin-bottom:10px"
      />
      <textarea
        v-model="selectedJob.responsibilities"
        class="form-control"
        rows="5"
        placeholder="Responsibilities" style="margin-bottom:10px"
      ></textarea>
      <textarea
        v-model="selectedJob.qualifications"
        class="form-control"
        rows="5"
        placeholder="Qualifications" style="margin-bottom:10px"
      ></textarea>
    </div>

    <!-- Footer -->
    <div class="flex justify-end gap-2 mt-4">
      <button class="btn btn-secondary mx-3" @click="closeEditForm">Cancel</button>
      <button class="btn btn-success" @click="updateJob">Save</button>
    </div>

  </div>
</div>



</template>

<script>
import api from '../api';
import jsPDF from "jspdf";
import {
  PlusOutlined,
  DownloadOutlined,
  EditOutlined
} from '@ant-design/icons-vue';
export default {
  name: 'JobDescription',
  data() {
    return {
      jobs: [],
      selectedJob: null,
      showEditForm: false,

    }
  },
  components: {

    PlusOutlined,
    DownloadOutlined,
    EditOutlined
  },
  mounted() {
    this.getJobDescription();
  },

  methods: {
    async getJobDescription() {
      try {
        const response = await api.get('/jobs');
        this.jobs = response.data;
      } catch (error) {
        console.error('Error in fetching job description', error);
      }
    },
    downloadPDF(job) {
      const doc = new jsPDF("p", "mm", "a4");

      const pageWidth = doc.internal.pageSize.getWidth();
      const pageHeight = doc.internal.pageSize.getHeight();

      // 🔹 Background color (light gray-blue)
      doc.setFillColor(244, 246, 249); // #f4f6f9
      doc.rect(0, 0, pageWidth, pageHeight, "F");

      // 🔹 White card in the center
      doc.setFillColor(255, 255, 255); // white
      doc.roundedRect(15, 15, pageWidth - 30, pageHeight - 30, 5, 5, "F");

      // Header
      doc.setFont("helvetica", "bold");
      doc.setFontSize(20);
      doc.setTextColor(44, 62, 80); // Dark gray
      doc.text("Job Description", pageWidth / 2, 30, {
        align: "center"
      });

      // Line under title
      doc.setDrawColor(52, 152, 219); // blue line
      doc.setLineWidth(0.7);
      doc.line(25, 35, pageWidth - 25, 35);

      // Job Title & ID
      doc.setFontSize(12);
      doc.setFont("helvetica", "normal");
      doc.setTextColor(51, 51, 51);
      doc.text(`Job Title: ${job.title}`, 25, 50);
      doc.text(`Job ID: ${job.id}`, 25, 60);
      doc.text(`Department: ${job.department}`, 25, 70);

      let y = 90;
      doc.setFont("helvetica", "bold");
      doc.setTextColor(44, 62, 80);
      doc.text("Responsibilities:", 25, y);

      doc.setFont("helvetica", "normal");
      doc.setTextColor(80, 80, 80);
      y += 10;
      const responsibilities = doc.splitTextToSize(job.responsibilities || "-", 160);
      doc.text(responsibilities, 25, y);
      y += responsibilities.length * 7;

      y += 10;
      doc.setFont("helvetica", "bold");
      doc.setTextColor(44, 62, 80);
      doc.text("Qualifications:", 25, y);

      doc.setFont("helvetica", "normal");
      doc.setTextColor(80, 80, 80);
      y += 10;
      const qualifications = doc.splitTextToSize(job.qualifications || "-", 160);
      doc.text(qualifications, 25, y);

      // Footer (date + page number)
      const pageCount = doc.internal.getNumberOfPages();
      doc.setFontSize(10);
      doc.setTextColor(120);
      doc.text(`Generated on: ${new Date().toLocaleDateString()}`, 25, pageHeight - 15);
      doc.text(`Page 1 of ${pageCount}`, pageWidth - 40, pageHeight - 15);

      // Save as file
      doc.save(`job_description_${job.id}.pdf`);
    },
    async editJob(job) {
    try {
      const res = await api.get(`/jobs/${job.id}`);
      this.selectedJob = res.data;
      this.showEditForm = true; 
    } catch (error) {
      console.error(error);
    }
  },

  closeEditForm() {
    this.showEditForm = false;  // hide the modal
    this.selectedJob = null;
  },

  async updateJob() {
    try {
      await api.put(`/jobs/${this.selectedJob.id}`, this.selectedJob);
      this.getJobDescription();  
      this.closeEditForm();
    } catch (error) {
      console.error(error);
    }
  },


  }
}
</script>

<style scoped>
.btn {
  background-color: #00B4D8;
  color: white;
}

.job-list-container {
  background-color: #f8f9fa;
  /* Light gray background for the page */
}

.job-card-custom {
  border: 1px solid #dee2e6;
  /* A subtle, light border */
  border-radius: 10px;
  /* Slightly more rounded corners */
  transition: transform 0.2s ease-in-out;
}

.job-card-custom:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15) !important;
}

.job-title-custom {
  font-weight: 700;
  font-size: 1.6rem;
  color: #343a40;
}

.detail-label {
  font-weight: 600;
  font-size: 0.9rem;
  letter-spacing: 0.5px;
}

.detail-text {
  font-size: 1rem;
  color: #495057;
  line-height: 1.6;
  white-space: pre-wrap;
}

.card-body {
  padding: 1.5rem;
}

.mb-4 {
  margin-bottom: 1.5rem !important;
}

.container-fluid {
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 9999;
}

.modal-container {
  width: 80%;          /* Wider modal */
  max-width: 900px;    /* Prevents it from going too wide */
  max-height: 90vh;    /* Max height relative to viewport */
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 10px 25px rgba(0,0,0,0.2);
  padding: 2rem;
  position: relative;
  display: flex;
  flex-direction: column;
  overflow: hidden;    /* Ensures scroll happens inside body */
}

.modal-body {
  overflow-y: auto;    /* Scrollable if content is too tall */
  max-height: 60vh;    /* Adjust as needed */
  padding-right: 0.5rem; /* For scrollbar spacing */
}

.btn-close {
  background: transparent;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
}


</style>
