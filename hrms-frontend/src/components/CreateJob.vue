<template>
  <div class="d-flex justify-content-center align-items-center vh-100 bg-light">
  <div class="card shadow-lg p-4" style="width: 450px; border-radius: 12px;">
    <h2 class="text-center mb-4">Create Job Description</h2>
    
    <form @submit.prevent="createJob">
      <!-- Job Title -->
      <div class="mb-3">
        <label class="form-label fw-bold">Job Title</label><span style="color:red"> *</span>
        <input 
          v-model="form.title" 
          type="text" 
          class="form-control" 
          placeholder="Enter Job Title" 
          required
        />
      </div>

      <!-- Department -->
      <div class="mb-3">
        <label class="form-label fw-bold">Department</label><span style="color:red"> *</span>
        <input 
          v-model="form.department" 
          type="text" 
          class="form-control" 
          placeholder="Enter Department" 
          required
        />
      </div>

      <!-- Responsibilities -->
      <div class="mb-3">
        <label class="form-label fw-bold">Responsibilities</label><span style="color:red"> *</span>
        <textarea 
          v-model="form.responsibilities" 
          class="form-control" 
          rows="3" 
          placeholder="List Responsibilities"
        ></textarea>
      </div>

      <!-- Qualifications -->
      <div class="mb-3">
        <label class="form-label fw-bold">Qualifications</label><span style="color:red"> *</span>
        <textarea 
          v-model="form.qualifications" 
          class="form-control" 
          rows="3" 
          placeholder="List Qualifications"
        ></textarea>
      </div>

      <!-- Submit Button -->
      <div class="d-grid">
        <button type="submit" class="btn btn-lg">
          <i class="bi bi-plus-circle me-2"></i> Create Job
        </button>
      </div>
    </form>
  </div>
</div>

</template>
<script>
import api from '../api';
export default {
  name: 'CreateJob',
  data() {
    return {
      job:'',
      form: {
        title: '',
        department: '',
        responsibilities: '',
        qualifications: ''
      }
    };
  },
  methods: {
    async createJob() {
      try{
        const response=await api.post('/jobs',this.form);
        this.job=response.data.job;
        this.resetForm();
        alert('Job created successfully');
        this.$router.push('/job-description');
      }
      catch(error){
        console.error('Error in creating job');
    }    
  },
  resetForm(){
    this.form={
      title:'',
      department:'',
      responsibilities:'',
      qualifications:''
    };
  }
}
};
</script>
<style scoped>
.btn {
  background-color: #0077B6;
  color: white;

}
</style>
