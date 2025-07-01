import api from './BaseService';
const baseURL = '/patients';
const PatientApiService = {
  async getAll(page = 1) {
    try {
      let response = await api.get(`${baseURL}?page=${page}`); 
      return response.data;
    } catch (error) {
      throw error
    }
    return api.get(`${baseURL}`);
  },
  async getPatientsList() {
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
  create(patient) {
    return api.post('/patients', patient);
  },
  update(id, patient) {
    return api.put(`/patients/${id}`, patient);
  },
  delete(id) {
    return api.delete(`${baseURL}/${id}`);
  },
};

export default PatientApiService;
