<!-- src/components/TopNav.vue -->
<template>
  <div class="top-nav d-flex align-items-center justify-content-between px-3 py-2 shadow-sm">
    <!-- Left: Logo & Toggle -->
    <div class="d-flex align-items-center">
      <img :src="require('@/assets/hrms-logo.png')" alt="Logo" style="height: 40px;" />
      <button class="btn btn-link text-primary ms-3">
        <i class="bi bi-list" style="font-size: 24px;"></i>
      </button>
    </div>

    <!-- Right: Month selector, Notification, User -->
    <div class="d-flex align-items-center gap-3">
      <div>
        <span class="text-primary me-1 fw-bold">Month:</span>
        <input type="text" class="form-control form-control-sm d-inline-block" style="width: 100px;" value="AUG/2025" readonly />
      </div>

      <i class="bi bi-bell" style="font-size: 18px;"></i>

      <div class="d-flex align-items-center">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Profile" style="width: 28px; height: 28px; border-radius: 50%; border: 2px solid #0db2e5;" />
        <span class="text-primary fw-bold ms-2">Vidisha Prabhu</span>
        <i class="bi bi-caret-down-fill ms-1 text-primary" style="font-size: 12px;"></i>
      </div>
    </div>
  </div>
</template>

<style scoped>
.top-nav {
  height: 60px;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 1100;
}
</style>
