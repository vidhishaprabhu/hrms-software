<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-header text-center">
          </div>
          <div class="card-body">
            <form @submit.prevent="changePassword">
              <div class="mb-3">
                <label class="form-label">Current Password</label>
                <input 
                  type="password" 
                  v-model="form.current_password" 
                  class="form-control" 
                  placeholder="Enter current password" 
                  required 
                />
              </div>

              <div class="mb-3">
                <label class="form-label">New Password</label>
                <input 
                  type="password" 
                  v-model="form.new_password" 
                  class="form-control" 
                  placeholder="Enter new password" 
                  required 
                />
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm New Password</label>
                <input 
                  type="password" 
                  v-model="form.new_password_confirmation" 
                  class="form-control" 
                  placeholder="Confirm new password" 
                  required 
                />
              </div>

              <div class="d-grid">
                <button type="submit" class="btn">
                  Change Password
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import api from '../api';
export default{
  name:'ChangePassword',
data(){
  return{
    form: 
    {
        current_password: "",
        new_password: "",
        new_password_confirmation: ""
    },
    userData:[],
  }
},
 mounted(){
  this.getUser();

},
methods:{
  async getUser(){
    try{
      const response=await api.get('/get-user-data');
      this.userData=response.data;

    }
    catch(error){
      console.error("Error in fetching user data");
    }

  },
  async changePassword() {
    try {
    const response = await api.put(`change-password/${this.userData.id}`, {
      current_password: this.form.current_password,
      new_password: this.form.new_password,
      new_password_confirmation: this.form.new_password_confirmation,
    });

    this.message = response.data.message;
    alert(this.message);
  } catch (error) {
    this.message = error.response?.data?.message || "Error changing password.";
  }
  }

}

}
</script>
<style scoped>
.btn {
  background-color: #00B4D8;
  color: white;
}
</style>