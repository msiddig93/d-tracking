import api from './BaseService';
const baseURL = '/doctors';
const DoctorApiService = {
  async getAll(page = 1) {
    try {
      let response = await api.get(`${baseURL}?page=${page}`); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  async getDoctorsList() {
    try {
      let response = await api.get(`${baseURL}/list`); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  get(id) {
    return api.get(`/${baseURL}/${id}`);
  },
  async create(doctor) {
    try {
      let response = await api.post(`${baseURL}`, doctor); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  update(id, doctor) {
    return api.put(`/doctors/${id}`, doctor);
  },
  delete(id) {
    return api.delete(`/doctors/${id}`);
  },
};

export default DoctorApiService;
