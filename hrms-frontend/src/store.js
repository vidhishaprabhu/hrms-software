// src/store.js
// src/store.js
import { createStore } from 'vuex';

export default createStore({
  state: {
    checkInTime: null,
  },
  mutations: {
    setCheckInTime(state, time) {
      state.checkInTime = time;
    },
    clearCheckInTime(state) {
      state.checkInTime = null;
    }
  }
});
