import axios from 'axios';

const isProduction = import.meta.env.VITE_APP_ENV === 'production';
console.log('isProduction:', isProduction);
const API_URL = isProduction ? 'https://nakahara.pro' : 'http://localhost:8000';
const apiClient = axios.create({
  baseURL: API_URL,
  withCredentials: isProduction,
});

export default apiClient;