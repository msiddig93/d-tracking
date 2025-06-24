import axios from 'axios';

const api = axios.create({
  baseURL: '/api/v1/dashboard',
  headers: {
    'Content-Type': 'application/json',
    // Add more headers if needed (e.g., Authorization)
  },
});

export default api;
