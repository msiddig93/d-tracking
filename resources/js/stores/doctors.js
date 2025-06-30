import { defineStore } from 'pinia';
import DoctorApiService from '../ApiServices/DoctorApiService';

export const useDoctorsStore = defineStore('doctors', {
  state: () => ({
    doctors: {},
    currentDoctor: {},
    loading: false,
    error: null,
    showAddDoctorModal: false,
  }),
  actions: {
    async fetchDoctors(page = 1) {
        try {
            this.loading = true;
            this.doctors = await DoctorApiService.getAll(page);
            this.loading = false;
        } catch (error) {
            this.loading = false;
            throw error;
        }
    },
    setCurrentDoctor(doctor) {
      this.currentDoctor = doctor;
    },
    async createDoctor(doctor) {
      try {
        await DoctorApiService.create(this.currentDoctor)
      } catch (error) {
        throw error
      }
    },
    setDoctors(doctors) {
      this.doctors = doctors;
    },
    clearDoctors() {
      this.doctors = [];
    },
    toggleDoctorModal() {
      this.showAddDoctorModal = !this.showAddDoctorModal;
    },
    async deleteDoctor(id) {
      try {
        await DoctorApiService.delete(id);
        this.fetchDoctors(); // Refresh the list after deletion
      } catch (error) {
        throw error;
      }
    }
  },
});
