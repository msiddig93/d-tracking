import api from './BaseService';

const PatientApiService = {
  getAll() {
    return api.get('/patients');
  },
  get(id) {
    return api.get(`/patients/${id}`);
  },
  create(patient) {
    return api.post('/patients', patient);
  },
  update(id, patient) {
    return api.put(`/patients/${id}`, patient);
  },
  delete(id) {
    return api.delete(`/patients/${id}`);
  },
};

export default PatientApiService;
