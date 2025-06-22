import axios from 'axios'

const api = axios.create({
  baseURL: 'http://localhost:8000', // URL backend
  headers: {
    'Content-Type': 'application/json',
    Accept: 'application/json',
  },
  withCredentials: false, // jangan pakai true jika tidak menggunakan Sanctum
})

export default api
