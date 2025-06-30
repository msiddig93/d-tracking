import api from './BaseService';
const baseURL = '/glucose-tests';
const GlucoseTestApiService = {
  async getAll(page = 1) {
    try {
      let response = await api.get(`${baseURL}?page=${page}`); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  async getGlucoseTestsList() {
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
  async create(glucoseTest) {
    try {
      let response = await api.post(`${baseURL}`, glucoseTest); 
      return response.data;
    } catch (error) {
      throw error
    }
  },
  update(id, glucoseTest) {
    return api.put(`/glucoseTests/${id}`, glucoseTest);
  },
  delete(id) {
    return api.delete(`/glucoseTests/${id}`);
  },
};

export default GlucoseTestApiService;
