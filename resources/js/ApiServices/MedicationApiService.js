import api from './BaseService';
const baseURL = '/medications';
const MedicationApiService = {
  async getAll(page = 1) {
    try {
      let response = await api.get(`${baseURL}?page=${page}`); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  async getMedicationsList() {
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
  async create(medication) {
    try {
      let response = await api.post(`${baseURL}`, medication); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  update(id, medication) {
    return api.put(`/medications/${id}`, medication);
  },
  delete(id) {
    return api.delete(`/medications/${id}`);
  },
};

export default MedicationApiService;
