import { defineStore } from 'pinia';
import PatientApiService from '../ApiServices/PatientApiService';

export const usePatientsStore = defineStore('patients', {
  state: () => ({
    patients: {},
    patientsList: [],
    currentPatient: {},
    loading: false,
    error: null,
  }),
  actions: {
    async fetchPatients(page = 1) {
        try {
            this.loading = true;
            this.patients = await PatientApiService.getAll(page);
            this.loading = false;
            
        } catch (error) {
            this.loading = false;
            throw error;
        }
    },
    async fetchPatientsList() {
      try {
        this.patientsList = await PatientApiService.getPatientsList();
      } catch (error) {
        throw error;
      }
    },
    setCurrentPatient(patient) {
      this.currentPatient = patient;
    },
    setPatients(patients) {
      this.patients = patients;
    },
    clearPatients() {
      this.patients = [];
    },
  },
});
