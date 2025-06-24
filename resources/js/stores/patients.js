import { defineStore } from 'pinia';
import PatientApiService from '../ApiServices/PatientApiService';

export const usePatientsStore = defineStore('patients', {
  state: () => ({
    patients: [],
    loading: false,
    error: null,
  }),
  actions: {
    async fetchPatients() {
      this.loading = true;
      this.error = null;
      try {
        const response = await PatientApiService.getAll();
        this.patients = response.data;
      } catch (err) {
        this.error = err.response?.data?.message || err.message || 'Unknown error';
      } finally {
        this.loading = false;
      }
    },
    setPatients(patients) {
      this.patients = patients;
    },
    clearPatients() {
      this.patients = [];
    },
  },
});
