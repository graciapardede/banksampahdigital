import axios from 'axios';

// Small wrapper around axios for the project's API endpoints.
// All requests use the defaults configured in `bootstrap.js` (baseURL, CSRF, withCredentials).

const handleResponse = (res) => res.data;

export const api = {
  // Public
  getBranches() {
    return axios.get('/branches').then(handleResponse);
  },
  getWasteTypes() {
    return axios.get('/waste-types').then(handleResponse);
  },
  getRewardItems() {
    return axios.get('/reward-items').then(handleResponse);
  },

  // Deposits
  getDeposits(params = {}) {
    return axios.get('/deposits', { params }).then(handleResponse);
  },
  getDeposit(id) {
    return axios.get(`/deposits/${id}`).then(handleResponse);
  },
  createDeposit(payload) {
    return axios.post('/deposits', payload).then(handleResponse);
  },

  // Redemptions
  getRedemptions(params = {}) {
    return axios.get('/redemptions', { params }).then(handleResponse);
  },
  getRedemption(id) {
    return axios.get(`/redemptions/${id}`).then(handleResponse);
  },
  createRedemption(payload) {
    return axios.post('/redemptions', payload).then(handleResponse);
  },

  // Utility: get current authenticated user (requires auth:sanctum)
  me() {
    return axios.get('/me').then(handleResponse);
  }
};

export default api;

// Expose for quick usage from inline Alpine components or other scripts
if (typeof window !== 'undefined') {
  window.api = api;
}
