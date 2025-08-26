<template>
  <div class="container mt-4">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-3">
          <div class="card-header bg-primary text-white text-center">
            <h5 class="mb-0">Change Password</h5>
          </div>
          <div class="card-body">
            <form @submit.prevent="changePassword">
              
              <!-- Current Password -->
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

              <!-- New Password -->
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

              <!-- Confirm New Password -->
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

              <!-- Submit Button -->
              <div class="d-grid">
                <button type="submit" class="btn btn-success">
                  Change Password
                </button>
              </div>
            </form>
          </div>
        </div>

        <!-- Message -->
        <div v-if="message" class="alert alert-info mt-3 text-center">
          {{ message }}
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default{
  name:'ChangePassword',
data(){
  return{
    form: {
        current_password: "",
        new_password: "",
        new_password_confirmation: ""
      },
  }
}

}
</script>
